<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Campaign
 * 
 * @property int $id
 * @property string $name
 * @property int $beneficiary_id
 * @property int $target_amount
 * @property int $target_amount_extra
 * @property string $currency
 * @property int $cover_photo_id
 * @property string $description_short
 * @property string $description_full
 * @property int $organization_id
 * @property int $current_funds
 * @property string $status
 * @property int $funds_transferred_amount
 * @property int $donors_number
 * @property string $type
 * @property int $administrator_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $edited_at
 * @property int $priority
 * @property string $slug
 * @property string $tags
 * @property \Carbon\Carbon $action_by_date
 * @property \Carbon\Carbon $ends
 * @property string $reference_id
 * @property string $end_notes
 * @property string $media_info
 * 
 * @property \App\Models\Admin $admin
 * @property \App\Models\Beneficiary $beneficiary
 * @property \App\Models\Medium $medium
 * @property \App\Models\Organization $organization
 * @property \Illuminate\Database\Eloquent\Collection $campaign_reports
 * @property \Illuminate\Database\Eloquent\Collection $donations
 * @property \Illuminate\Database\Eloquent\Collection $goods_inputs
 * @property \Illuminate\Database\Eloquent\Collection $media_links
 * @property \Illuminate\Database\Eloquent\Collection $monetary_inputs
 * @property \Illuminate\Database\Eloquent\Collection $subscriptions
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
