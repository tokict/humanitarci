<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;



/**
 * Class Donor
 * Donor is any person or legal_entity that is registered as a donor on the site
 * 
 * @property int $id
 * @property int $beneficiary_id
 * @property int $campaign_id
 * @property int $donor_id
 * @property int $amount
 * @property int $organization_id
 * @property string $status
 *
 *
 *
 * @property \App\Models\Beneficiary $beneficiary
 * @property \App\Models\Campaign $campaign
 * @property \App\Models\Donor $donor
 * @property \App\Models\Organization $organization
 *
 * @property \Carbon\Carbon $created_at
 *
 *
 * @package App\Models
 */
class RecurringDonation extends BaseModel
{
	public $timestamps = false;

	protected $casts = [
		'beneficiary_id' => 'int',
		'campaign_id' => 'int',
		'donor_id' => 'int',
		'amount' => 'int',
		'organization_id' => 'int',
	];

	protected $dates = [
		'modified_at'
	];

	protected $fillable = [
		'beneficiary_id',
		'campaign_id',
		'donor_id',
		'amount',
		'created_at',
		'organization_id',
		'status'

	];

	public function beneficiary()
	{
		return $this->hasMany(\App\Models\Beneficiary::class);
	}

	public function campaign()
	{
		return $this->hasMany(\App\Models\Campaign::class);
	}

	public function donor()
	{
		return $this->hasMany(\App\Models\Donor::class);
	}

	public function organization()
	{
		return $this->belongsTo(\App\Models\Organization::class);
	}

}
