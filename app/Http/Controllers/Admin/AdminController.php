<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beneficiary;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Donor;
use App\Models\LegalEntity;
use App\Models\Media;
use App\Models\MonetaryInput;
use App\Models\MonetaryOutput;
use App\Models\Person;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    use \App\Traits\ControllerIndexTrait;

    public function home(\Illuminate\Http\Request $request,$id = null)
    {
        $this->index($request, false);

        if (Auth::User() && Auth::User()->super_admin && !$id) {
            $campaigns = Campaign::count('created_at', '>=', Carbon::now()->startOfWeek());
            $persons = Person::count('created_at', '>=', Carbon::now()->startOfWeek());
            $donors = Donor::count('created_at', '>=', Carbon::now()->startOfWeek());
            $donations = Donation::count('created_at', '>=', Carbon::now()->startOfWeek());
            $funds = Donation::where('created_at', '>=', Carbon::now()->startOfWeek())->sum('amount');
            $beneficiaries = Beneficiary::count('created_at', '>=', Carbon::now()->startOfWeek());
            $legal_entities = LegalEntity::count('created_at', '>=', Carbon::now()->startOfWeek());
        } else {
            $campaigns = Campaign::where('created_at', '>=', Carbon::now()->startOfWeek())->where('organization_id', Auth::User()->admin->organization_id)->count();
            $persons = Person::where('created_at', '>=', Carbon::now()->startOfWeek())->with(['Admin' => function ($q) {
                $q->where('organization_id', Auth::User()->admin->organization_id);
            }])->count();
            $donors = null;
            $donations = Donation::where('created_at', '>=', Carbon::now()->startOfWeek())->where('organization_id', Auth::User()->admin->organization_id)->count();
            $funds = Donation::where('created_at', '>=', Carbon::now()->startOfWeek())->where('organization_id', Auth::User()->admin->organization_id)->sum('amount');
            $beneficiaries = Beneficiary::where('created_at', '>=', Carbon::now()->startOfWeek())->with(['Admin' => function ($q) {
                $q->where('organization_id', Auth::User()->admin->organization_id);
            }])->count();
            $legal_entities = LegalEntity::where('created_at', '>=', Carbon::now()->startOfWeek())->with(['Admin' => function ($q) {
                $q->where('organization_id', Auth::User()->admin->organization_id);
            }])->count();

            //Amount in the campaigns left for distribution (ended campaigns -> amount - distributed amount)
            $qryBuilder = Campaign::where('status', 'succeeded')->where('organization_id', Auth::User()->admin->organization_id);
            $distributed_amount = 0;
            $amount_to_distribute = $qryBuilder->sum('target_amount');
            foreach ($qryBuilder->get() as $c) {
                $distributed = MonetaryOutput::where('campaign_id', $c->id);
                foreach ($distributed as $out) {
                    $distributed_amount += $out->amount;
                }
            }


            $amount_to_distribute = number_format(($amount_to_distribute - $distributed_amount) / 100);

            //Documents to upload for campaign end (succeeded campaigns without needed documents)
            $documents_to_upload = Campaign::where('status', 'succeeded')
                ->where('action_by_date', '<=', date('Y-m-d H:i:s'))
                ->where('organization_id', Auth::User()->admin->organization_id)
                ->whereNull('beneficiary_receipt_doc_id')->count();


            //Distributions left that are behind schedule (ended campaigns -> amount - distributed amount that is beyond action date)

            $qryBuilder = Campaign::where('status', 'succeeded')->where('action_by_date', '<=', date('Y-m-d H:i:s'))->where('organization_id', Auth::User()->admin->organization_id);
            $distributed_amount_late = 0;
            $late_distributions = $qryBuilder->sum('target_amount');
            foreach ($qryBuilder->get() as $c) {
                $distributed = MonetaryOutput::where('campaign_id', $c->id);
                foreach ($distributed as $out) {
                    $distributed_amount_late += $out->amount;
                }
            }
            $late_distributions = number_format(($late_distributions - $distributed_amount_late) / 100);
        }

        return view('admin.index', [
            'campaigns' => $campaigns,
            'persons' => $persons,
            'donors' => $donors,
            'funds' => $funds,
            'donations' => $donations,
            'beneficiaries' => $beneficiaries,
            'legal_entities' => $legal_entities,
            'super' => Auth::User()->super_admin && !$id,
            'late_distributions' => isset($late_distributions) ? $late_distributions : null,
            'documents_to_upload' => isset($documents_to_upload) ? $documents_to_upload : null,
            'amount_to_distribute' => isset($amount_to_distribute) ? $amount_to_distribute : null
        ]);
    }


    public function donations()
    {

        $donation_nr = Donation::with('Campaign')->whereHas('Campaign', function ($q) {
            $q->where('organization_id', Auth::User()->admin->organization_id);
        })->whereBetween('created_at', [Carbon::parse('this week')->toDateString(), Carbon::parse('this week')->addDays(7)->toDateString()])->count();

        $total_amount = Donation::with('Campaign')->whereHas('Campaign', function ($q) {
            $q->where('organization_id', Auth::User()->admin->organization_id);
        })->whereBetween('created_at', [Carbon::parse('this week')->toDateString(), Carbon::parse('this week')->addDays(7)->toDateString()])->sum('amount');

        $donations_average = Donation::with('Campaign')->whereHas('Campaign', function ($q) {
            $q->where('organization_id', Auth::User()->admin->organization_id);
        })->whereBetween('created_at', [Carbon::parse('this week')->toDateString(), Carbon::parse('this week')->addDays(7)->toDateString()])->avg('amount');

        $biggest_donors = Donation::with('Campaign')->whereHas('Campaign', function ($q) {
            $q->where('organization_id', Auth::User()->admin->organization_id);
        })->whereBetween('created_at', [Carbon::parse('this week')->toDateString(), Carbon::parse('this week')->addDays(7)->toDateString()])->orderBy('amount', 'desc')
            ->get();

        $data = [
            'total_nr_donations' => isset($donation_nr)?$donation_nr:0,
            'total_donations_amount' => $total_amount,
            'donations_average' => $donations_average,
            'biggest_donors' => $biggest_donors
        ];

        return view('admin.overview.donations', $data);
    }

    public function distributions()
    {
        $starting_amount = '';
        $total_out = MonetaryOutput::with('Admin')->whereHas('Admin', function($q){
            $q->where('organization_id', Auth::User()->admin->organization_id);
        })->whereBetween('created_at', [Carbon::parse('this week')->toDateString(), Carbon::parse('this week')->addDays(7)->toDateString()])->sum('amount');

        $total_nr_out = MonetaryOutput::with('Admin')->whereHas('Admin', function($q){
            $q->where('organization_id', Auth::User()->admin->organization_id);
        })->whereBetween('created_at', [Carbon::parse('this week')->toDateString(), Carbon::parse('this week')->addDays(7)->toDateString()])->count();

        $outs = MonetaryOutput::with('Admin')->whereHas('Admin', function($q){
            $q->where('organization_id', Auth::User()->admin->organization_id);
        })->whereBetween('created_at', [Carbon::parse('this week')->toDateString(), Carbon::parse('this week')->addDays(7)->toDateString()])->paginate(20);

        foreach($outs as $o){
            $media_info = Media::whereIn('id', explode(",", $o->receipt_ids))->get();
            $o->receipts = $media_info;
        }

        $data = [
            'starting_amount' => $starting_amount,
            'total_out' => $total_out,
            'total_nr_out' => $total_nr_out,
            'outs' => $outs
        ];


        return view('admin.overview.distributions', $data);
    }

    public function campaigns()
    {
        //Campaigns that are active
        $campaigns_active = Campaign::where('organization_id', Auth::User()->admin->organization_id)
            ->where('status', 'active')
            ->count();

        //Campaigns to start this week
        $campaigns_pending = Campaign::where('organization_id', Auth::User()->admin->organization_id)
            ->where('status', 'inactive')
            ->whereBetween('starts',  [date("Y-m-d H:i:s"), Carbon::parse('this week')->addDays(7)->toDateString()])->count();

        //Campaigns ended this week
        $campaigns_ended = Campaign::where('organization_id', Auth::User()->admin->organization_id)
            ->where('status', 'inactive')
            ->whereBetween('ends',  [Carbon::parse('this week')->toDateString(), date("Y-m-d H:i:s")])->count();

        $campaigns_succeeded = Campaign::where('organization_id', Auth::User()->admin->organization_id)
            ->where('status', 'succeeded')
            ->where('succeeded_at', '>', Carbon::parse('next week')->subDays(7)->toDateString())->count();


        $campaigns_popular = Campaign::where('organization_id', Auth::User()->admin->organization_id)->with('Donations')->get()->sortBy(function ($q) {
            return $q->donations->count();
        }, $options = SORT_REGULAR, true)->take(3);


        $return = [
            'campaigns_active' => $campaigns_active,
            'campaigns_pending' => $campaigns_pending,
            'campaigns_ended' => $campaigns_ended,
            'campaigns_popular' => $campaigns_popular,
            'campaigns_succeeded' => $campaigns_succeeded
        ];

        return view('admin.overview.campaigns', $return);
    }

    public function donors()
    {
        $new_donors = Donor::with('Donations')->whereBetween('created_at',
            [Carbon::parse('this week')->toDateString(), Carbon::parse('this week')->addDays(7)->toDateString()])->whereHas('Donations',
            function ($q) {
                $q->where('organization_id', Auth::User()->admin->organization_id);
            })->count();

        $new_donors_sum = Donation::with('Donor')->whereHas('Donor',
            function ($q) {
                $q->whereBetween('created_at',
                    [Carbon::parse('this week')->toDateString(), Carbon::parse('this week')->addDays(7)->toDateString()]);
            })->where('organization_id', Auth::User()->admin->organization_id)->sum('amount');


        $new_donors_donations_nr = Donation::with('Donor')->whereHas('Donor',
            function ($q) {
                $q->whereBetween('created_at',
                    [Carbon::parse('this week')->toDateString(), Carbon::parse('this week')->addDays(7)->toDateString()]);
            })->where('organization_id', Auth::User()->admin->organization_id)->count();


        $new_donors_campaigns_donated = Campaign::with('Donations')->whereHas('Donations',
            function ($q) {
                $q->whereBetween('created_at',
                    [Carbon::parse('this week')->toDateString(), Carbon::parse('this week')->addDays(7)->toDateString()]);
            })->where('organization_id', Auth::User()->admin->organization_id)->count();


        $biggest_new_donors = Donor::with('Donations')->whereHas('Donations', function ($q) {
            $q->where('organization_id', Auth::User()->admin->organization_id);
        })->whereBetween('created_at', [Carbon::parse('this week')->toDateString(), Carbon::parse('this week')->addDays(7)->toDateString()])
            ->get()
            ->sortBy(function ($q) {
                return $q->donations->count();
            }, $options = SORT_REGULAR, true)->take(3);

        $data = [
            'new_donors' => $new_donors,
            'new_donors_sum' => (int) $new_donors_sum,
            'new_donors_average_donation' => !empty($new_donors_donations_nr)?$new_donors_sum/$new_donors_donations_nr:0,
            'new_donors_donations_nr' => $new_donors_donations_nr,
            'new_donors_campaigns_donated' => $new_donors_campaigns_donated,
            'biggest_new_donors' => $biggest_new_donors

        ];

        return view('admin.overview.donors', $data);
    }

    public function incomes()
    {
        $starting_amount = '';
        $total_in = MonetaryInput::with('Donations')->whereHas('Donations', function($q){
            $q->where('organization_id', Auth::User()->admin->organization_id);
        })->whereBetween('created_at', [Carbon::parse('this week')->toDateString(), Carbon::parse('this week')->addDays(7)->toDateString()])->sum('amount');

        $total_nr_in = MonetaryInput::with('Donations')->whereHas('Donations', function($q){
            $q->where('organization_id', Auth::User()->admin->organization_id);
        })->whereBetween('created_at', [Carbon::parse('this week')->toDateString(), Carbon::parse('this week')->addDays(7)->toDateString()])->count();

        $ins = MonetaryInput::with('Donations')->whereHas('Donations', function($q){
            $q->where('organization_id', Auth::User()->admin->organization_id);
        })->whereBetween('created_at', [Carbon::parse('this week')->toDateString(), Carbon::parse('this week')->addDays(7)->toDateString()])->paginate(20);

        foreach($ins as $o){
            $media_info = Media::whereIn('id', explode(",", $o->receipt_ids))->get();
            $o->receipts = $media_info;
        }

        $data = [
            'starting_amount' => $starting_amount,
            'total_in' => (int) $total_in,
            'total_nr_in' => $total_nr_in,
            'ins' => $ins
        ];


        return view('admin.overview.incomes', $data);
    }

    public function transactions()
    {

        $total = Transaction::with('from_donation')->whereHas('from_donation', function($q){
            $q->where('organization_id', Auth::User()->admin->organization_id);
        })->whereBetween('time', [Carbon::parse('this week')->toDateString(), Carbon::parse('this week')->addDays(7)->toDateString()])->sum('amount');

        $total_nr = Transaction::with('from_donation')->whereHas('from_donation', function($q){
            $q->where('organization_id', Auth::User()->admin->organization_id);
        })->whereBetween('time', [Carbon::parse('this week')->toDateString(), Carbon::parse('this week')->addDays(7)->toDateString()])->count();

        $total_campaigns_qry = Transaction::with('from_campaign')->whereHas('from_campaign', function($q){
            $q->where('organization_id', Auth::User()->admin->organization_id);
        })->whereBetween('time', [Carbon::parse('this week')->toDateString(), Carbon::parse('this week')->addDays(7)->toDateString()])->get();

        $campaigns = [];
        foreach($total_campaigns_qry as $t){
            if(!in_array($t->from_campaign_id, $campaigns)){
                $campaigns[] = $t->from_campaign_id;
            }
        }

        $transactions = Transaction::with('from_donation')->whereHas('from_donation', function($q){
            $q->where('organization_id', Auth::User()->admin->organization_id);
        })->whereBetween('time', [Carbon::parse('this week')->toDateString(), Carbon::parse('this week')->addDays(7)->toDateString()])->paginate(20);


        $data = [
            'total' => (int) $total,
            'total_nr' => $total_nr,
            'total_campaigns' => count($campaigns),
            'transactions' => $transactions
        ];


        return view('admin.overview.transactions', $data);
    }
}
