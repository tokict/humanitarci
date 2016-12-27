<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Carbon\Carbon;


/**
 * Class Campaign
 * Campaign is the main entity to which donors give donations.
 *
 * @property int $id
 *
 * @property string $name
 * The name of the campaign as it will appear on the campaign card
 *
 * @property int $beneficiary_id
 * The beneficiary who the donations will go to
 *
 * @property int $target_amount
 * Target amount that this campaign is aiming for if it has limits
 *
 * @property int $target_amount_extra
 * If the campaign had limits and needs more, it can request more donations. It can do this only once and until it
 * reaches the sum of target_amount and target_amount_extra. After that, the campaign ends and cannot be reactivated
 *
 *
 * @property int $cover_photo_id
 * The id of the cover photo for the campaign from media table. The image should be the one provoking the most empathy
 *
 * @property string $description_short
 * Short description for the campaign (150 chars)
 *
 * @property string $description_full
 * Full description of the campaign. Accepts html. The description should provoke empathy in donors
 *
 * @property int $organization_id
 * The organization that handles the campaing. It is inherited from admin who created the campaign. They MUST be same
 *
 * @property int $current_funds
 * Current state of donations for the campaign. Updated on every new donation for the campaign
 *
 * @property string $status
 * Status of campaign
 *
 * @property string $finalized_at
 * Date the campaign was finalized
 *
 *
 * @property string $succeeded_at
 * Date the campaign collected all the funds
 *
 * @property int $funds_transferred_amount
 *
 *
 * @property int $donors_number
 * Number of donors that participated in this campaign with donations
 *
 * @property string $type
 *
 * @property string $category
 *
 * @property \App\Models\Media $cover
 *
 * @property int $created_by_id
 * Id of admin who created campaign
 *
 *
 * @property int $registration_code
 * The code received from goverment on registration of the campaign
 *
 * @property int $classification_code
 * Code used to classify the campaign
 *
 * @property int $registration_doc_id
 *
 * @property int $action_plan_doc_id
 *
 * @property int $distribution_plan_doc_id
 *
 * @property int $registration_request_doc_id
 *
 * @property int $beneficiary_request_doc_id
 *
 * @property int $beneficiary_receipt_doc_id
 *
 * @property \Carbon\Carbon $created_at
 *
 * @property \Carbon\Carbon $modified_at
 *
 * @property int $priority
 * Optional priority of campaign to push it up in the queue to get more donations
 *
 * @property string $slug
 * String to use to directly access campaign page on paltform i.e humanitarci.hr/helpTheOrphans2016
 *
 * @property string $tags
 * Tags for the campaign to facilitate searches and categorization. Serialized array
 *
 * @property \Carbon\Carbon $action_by_date
 * This field tells the donors by which date will the beneficiary receive the donation. Optional but highly encouraged
 *
 * @property \Carbon\Carbon $ends
 * At which date does the campaign end if it does not have a target amount
 *
 * @property string $reference_id
 * Internal campaign reference
 *
 * @property string $end_notes
 * End notes isa a description made on and after delivery of goods to beneficiary. Short description must be present.
 *
 * @property string $media_info
 * Media used with this campaign. For creating cards, sharing, etc
 *
 * @property $end_media_info
 * Media related to campaign end and delivery
 *
 *
 * @property \App\User $creator
 * Related admin object
 *
 * @property \App\Models\Beneficiary $beneficiary
 * Related beneficiary object
 *
 *
 * @property \App\Models\Organization $organization
 * Related organization object
 *
 * @property Media $registration_request_doc
 *
 * @property Media $registration_doc
 *
 * @property Media$action_plan_doc
 *
 * @property Media $distribution_plan_doc
 *
 * @property Media $beneficiary_request_doc
 *
 * @property Media $beneficiary_receipt_doc
 *
 *
 * @property \Illuminate\Database\Eloquent\Collection $campaign_reports
 *
 *
 * @property \Illuminate\Database\Eloquent\Collection $donations
 *
 * @property \Illuminate\Database\Eloquent\Collection $goods_inputs
 *
 * @property \Illuminate\Database\Eloquent\Collection $media_links
 *
 * @property \Illuminate\Database\Eloquent\Collection $monetary_inputs
 *
 * @property \Illuminate\Database\Eloquent\Collection $monetary_outputs
 *
 * @property \Illuminate\Database\Eloquent\Collection $subscriptions
 *
 * @property \Illuminate\Database\Eloquent\Collection $transactions
 *
 * @package App\Models
 */
class Campaign extends BaseModel
{
    public $timestamps = false;

    protected $casts = [
        'beneficiary_id' => 'int',
        'target_amount' => 'int',
        'target_amount_extra' => 'int',
        'cover_photo_id' => 'int',
        'action_plan_doc_id' => 'int',
        'registration_doc_id' => 'int',
        'distribution_plan_doc_id' => 'int',
        'beneficiary_request_doc_id' => 'int',
        'registration_request_doc_id' => 'int',
        'organization_id' => 'int',
        'current_funds' => 'int',
        'funds_transferred_amount' => 'int',
        'donors_number' => 'int',
        'created_by_id' => 'int',
        'priority' => 'int',
        'beneficiary_receipt_doc' => 'int'
    ];

    protected $dates = [
        'modified_at',
        'action_by_date',
        'ends',
        'finalized_at'
    ];

    protected $fillable = [
        'name',
        'beneficiary_id',
        'target_amount',
        'target_amount_extra',
        'cover_photo_id',
        'description_short',
        'description_full',
        'organization_id',
        'current_funds',
        'status',
        'action_plan_doc_id',
        'registration_doc_id',
        'distribution_plan_doc_id',
        'beneficiary_request_doc_id',
        'registration_request_doc_id',
        'registration_code',
        'classification_code',
        'funds_transferred_amount',
        'donors_number',
        'type',
        'created_by_id',
        'modified_at',
        'priority',
        'slug',
        'tags',
        'action_by_date',
        'starts',
        'ends',
        'reference_id',
        'end_notes',
        'media_info',
        'category',
        'beneficiary_receipt_doc',
        'end_media_info',
        'finalized_at'
    ];

    /**
     * Reclculate donations and donors
     */
    public function recalculate()
    {
        $donations = Donation::where('campaign_id', $this->getAttribute('id'))->get();
        $target = $this->getAttribute('target_amount');

        $amount = 0;
        $donors = [];

        foreach ($donations as $donation) {
            $amount += $donation->amount;
            if (!in_array($donation->donor_idm, $donors)) {
                $donors[] = $donation->donor_id;
            }
        }
        $this->setAttribute('current_funds', $amount);
        $this->setAttribute('donors_number', count($donors));
        $this->setAttribute('percent_done', ($amount / $target) * 100);


    }


    public function beneficiary()
    {
        return $this->belongsTo(\App\Models\Beneficiary::class);
    }


    public function organization()
    {
        return $this->belongsTo(\App\Models\Organization::class);
    }

    public function campaign_reports()
    {
        return $this->hasMany(\App\Models\CampaignReport::class);
    }

    public function donations()
    {
        return $this->hasMany(\App\Models\Donation::class, 'campaign_id')->orderBy('created_at', 'desc');
    }

    public function goods_inputs()
    {
        return $this->hasMany(\App\Models\GoodsInput::class);
    }

    public function media_links()
    {
        return $this->hasMany(\App\Models\MediaLink::class);
    }

    public function monetary_inputs()
    {
        return $this->hasMany(\App\Models\MonetaryInput::class);
    }

    public function monetary_outputs()
    {
        return $this->hasMany(\App\Models\MonetaryOutput::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(\App\Models\Subscription::class, 'campaign_id');
    }

    public function transactions()
    {
        return $this->hasMany(\App\Models\Transaction::class);
    }


    public function cover()
    {
        return $this->belongsTo(\App\Models\Media::class, 'cover_photo_id');
    }

    public function registration_doc()
    {
        return $this->belongsTo(\App\Models\Media::class, 'registration_doc_id');
    }

    public function action_plan_doc()
    {
        return $this->belongsTo(\App\Models\Media::class, 'action_plan_doc_id');
    }

    public function distribution_plan_doc()
    {
        return $this->belongsTo(\App\Models\Media::class, 'distribution_plan_doc_id');
    }

    public function registration_request_doc()
    {
        return $this->belongsTo(\App\Models\Media::class, 'registration_request_doc_id');
    }

    public function beneficiary_request_doc()
    {
        return $this->belongsTo(\App\Models\Media::class, 'beneficiary_request_doc_id');
    }

    public function beneficiary_receipt_doc()
    {
        return $this->belongsTo(\App\Models\Media::class, 'beneficiary_receipt_doc_id');
    }

    public function creator()
    {
        return $this->belongsTo(\App\User::class, 'created_by_id');
    }

    public function getGraphAmountsData()
    {

        $amounts = [
            '0-50' => 0,
            '50-100' => 0,
            '100-200' => 0,
            '200-400' => 0,
            '400-600' => 0,
            '600-800' => 0,
            '1000-1500' => 0,
            '1500-15000' => 0
        ];


        foreach ($this->getReceivedDonations() as $receivedDonation) {
            foreach ($amounts as $key => $amount) {
                $x = explode("-", $key);
                $from = $x[0];
                $to = $x[1];

                if ($receivedDonation->amount / 100 > $from && $receivedDonation->amount / 100 <= $to) {
                    $amounts[$key] += 1;
                    continue 2;
                }

            }
        }

        $formatData = [];

        foreach ($amounts as $key => $amount) {
            $formatData[] = [$key, $amount];
        }

        return json_encode($formatData);
    }

    public function getReceivedDonations()
    {

        $donations = Donation::where('status', 'received')->where('campaign_id', $this->getAttribute('id'))->orderBy('created_at', 'desc')->get();

        return $donations;

    }

    public function getGraphDonationsTodayData()
    {

        $hours = [];

        for ($i = 0; $i < 23; $i++) {
            $carbon = new Carbon();
            $hour = $carbon->subHours($i);

            $hours[$hour->hour] = 0;
        }

        foreach ($this->getReceivedDonations() as $receivedDonation) {
            $hourAdded = $receivedDonation->created_at->hour;
            $hours[$hourAdded] += 1;
        }

        $formatData = [];

        foreach ($hours as $key => $hour) {
            $formatData[] = [$key, $hour];
        }
        $formatData = array_reverse($formatData);
        return json_encode($formatData);

    }

    public function getGraphDonationsTotalData()
    {
        $donationsDays = [];
        $carbon = new Carbon();
        $carbon2 = new Carbon($this->getAttribute('created_at'));
        $diff = $carbon->diffInDays($carbon2);

        for ($i = 0; $i < $diff; $i++) {
            $carb = new Carbon();
            $day = $carb->subDays($i);

            $donationsDays[$day->day . "-" . $day->month] = 0;
        }


        foreach ($this->getReceivedDonations() as $receivedDonation) {
            if (isset($donationsDays[$receivedDonation->created_at->format('d-m')])) {
                $donationsDays[$receivedDonation->created_at->format('d-m')] += 1;
            } else {
                $donationsDays[$receivedDonation->created_at->format('d-m')] = 1;
            }
        }

        $formatData = [];

        foreach ($donationsDays as $key => $day) {
            $formatData[] = [$key, $day];
        }

        $formatData = array_reverse($formatData);
        return json_encode($formatData);
    }


    /**
     * @return int Amount taken
     */
    public function getTakenFunds()
    {
        $taken = MonetaryOutput::whereCampaignId($this->getAtt('id'))->get()->sum('amount');

        return $taken ? $taken : 0;
    }

    public function getTotalDonationsFromDonor($id)
    {
        return Donation::where('donor_id', $id)->where('campaign_id', $this->getAtt('id'))->sum('amount');
    }
}
