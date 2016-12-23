<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beneficiary;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Donor;
use App\Models\LegalEntity;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    use \App\Traits\ControllerIndexTrait;

    public function home($id = null)
    {
        if (Auth::User()->super_admin && !$id) {
            $campaigns = Campaign::count('created_at', '>=', Carbon::now()->startOfWeek());
            $persons = Person::count('created_at', '>=', Carbon::now()->startOfWeek());
            $donors = Donor::count('created_at', '>=', Carbon::now()->startOfWeek());
            $donations = Donation::count('created_at', '>=', Carbon::now()->startOfWeek());
            $funds = Donation::where('created_at', '>=', Carbon::now()->startOfWeek())->sum('amount');
            $beneficiaries = Beneficiary::count('created_at', '>=', Carbon::now()->startOfWeek());
            $legal_entities = LegalEntity::count('created_at', '>=', Carbon::now()->startOfWeek());
        } else {
            $campaigns = Campaign::where('created_at', '>=', Carbon::now()->startOfWeek())->where('organization_id', Auth::User()->organization_id)->count();
            $persons = Person::where('created_at', '>=', Carbon::now()->startOfWeek())->with(['Admin' => function ($q) {
                $q->where('organization_id', Auth::User()->organization_id);
            }])->count();
            $donors = null;
            $donations = Donation::where('created_at', '>=', Carbon::now()->startOfWeek())->where('organization_id', Auth::User()->organization_id)->count();
            $funds = Donation::where('created_at', '>=', Carbon::now()->startOfWeek())->where('organization_id', Auth::User()->organization_id)->sum('amount');
            $beneficiaries = Beneficiary::where('created_at', '>=', Carbon::now()->startOfWeek())->with(['Admin' => function ($q) {
                $q->where('organization_id', Auth::User()->organization_id);
            }])->count();
            $legal_entities = LegalEntity::where('created_at', '>=', Carbon::now()->startOfWeek())->with(['Admin' => function ($q) {
                $q->where('organization_id', Auth::User()->organization_id);
            }])->count();

            //Amount in the campaigns left for distribution
            $amount_to_distribute = 999;

            //Documents to upload for campaign end
            $documents_to_upload = 999;

            //Distributions left that are behind schedule
            $late_distributions = 999;
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
            'late_distributions' => $late_distributions ? $late_distributions : null,
            'documents_to_upload' => $documents_to_upload ? $documents_to_upload : null,
            'amount_to_distribute' => $amount_to_distribute?$amount_to_distribute:null
        ]);
    }


    public function donations()
    {
        return view('admin.overview.donations');
    }

    public function distributions()
    {
        return view('admin.overview.distributions');
    }

    public function campaigns()
    {
        return view('admin.overview.campaigns');
    }

    public function donors()
    {
        return view('admin.overview.donors');
    }

    public function incomes()
    {
        return view('admin.overview.incomes');
    }

    public function transactions()
    {
        return view('admin.overview.transactions');
    }
}
