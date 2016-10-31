<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

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
 * @property string $currency
 * Which currency the target _amount is in. (ISO 3 char)
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
 * @property int $funds_transferred_amount
 *
 *
 * @property int $donors_number
 * Number of donors that participated in this campaign with donations
 *
 * @property string $type
 *
 * @property int $administrator_id
 * Id of admin who created campaign
 *
 * @property \Carbon\Carbon $created_at
 *
 * @property \Carbon\Carbon $edited_at
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
 *
 * @property string $media_info
 *
 * 
 * @property \App\Models\Admin $admin
 *
 * @property \App\Models\Beneficiary $beneficiary
 *
 * @property \App\Models\Medium $medium
 *
 * @property \App\Models\Organization $organization
 *
 * @property \Illuminate\Database\Eloquent\Collection $campaign_reports
 *
 * @property \Illuminate\Database\Eloquent\Collection $donations
 *
 * @property \Illuminate\Database\Eloquent\Collection $goods_inputs
 *
 * @property \Illuminate\Database\Eloquent\Collection $media_links
 *
 * @property \Illuminate\Database\Eloquent\Collection $monetary_inputs
 *
 * @property \Illuminate\Database\Eloquent\Collection $subscriptions
 *
 * @property \Illuminate\Database\Eloquent\Collection $transactions
 *
 * @package App\Models
 */
class Campaign extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'beneficiary_id' => 'int',
		'target_amount' => 'int',
		'target_amount_extra' => 'int',
		'cover_photo_id' => 'int',
		'organization_id' => 'int',
		'current_funds' => 'int',
		'funds_transferred_amount' => 'int',
		'donors_number' => 'int',
		'administrator_id' => 'int',
		'priority' => 'int'
	];

	protected $dates = [
		'edited_at',
		'action_by_date',
		'ends'
	];

	protected $fillable = [
		'name',
		'beneficiary_id',
		'target_amount',
		'target_amount_extra',
		'currency',
		'cover_photo_id',
		'description_short',
		'description_full',
		'organization_id',
		'current_funds',
		'status',
		'funds_transferred_amount',
		'donors_number',
		'type',
		'administrator_id',
		'edited_at',
		'priority',
		'slug',
		'tags',
		'action_by_date',
		'ends',
		'reference_id',
		'end_notes',
		'media_info'
	];

	public function admin()
	{
		return $this->belongsTo(\App\Models\Admin::class, 'administrator_id');
	}

	public function beneficiary()
	{
		return $this->belongsTo(\App\Models\Beneficiary::class);
	}

	public function medium()
	{
		return $this->belongsTo(\App\Models\Medium::class, 'cover_photo_id');
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
		return $this->hasMany(\App\Models\Donation::class);
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

	public function subscriptions()
	{
		return $this->hasMany(\App\Models\Subscription::class, 'campaing_id');
	}

	public function transactions()
	{
		return $this->hasMany(\App\Models\Transaction::class);
	}
}