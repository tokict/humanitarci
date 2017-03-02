<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;



/**
 * Class Subscription
 * There are the recurring donations that happen only for specific type of campaign that support recurring.
 * 
 * @property int $id
 * @property int $donor_id
 * Donor that subscribes
 *
 * @property int $campaing_id
 * Subscribing to campaign id
 *
 * @property int $amount
 * Amount to be charged
 *
 * @property int $service_id
 * Service to be requested
 *
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $modified_at
 * @property string $status
 * Status of subscription
 * @property string $processing_data
 * 
 * @property \App\Models\Campaign $campaign
 * @property \App\Models\Donor $donor
 * @property \App\Models\ServicesList $services_list
 *
 * @package App\Models
 */
class Subscription extends BaseModel
{
	public $timestamps = false;

	protected $casts = [
		'donor_id' => 'int',
		'campaing_id' => 'int',
		'amount' => 'int',
		'service_id' => 'int'
	];

	protected $dates = [
		'modified_at'
	];

	protected $fillable = [
		'donor_id',
		'campaing_id',
		'amount',
		'service_id',
		'modified_at',
		'status',
		'processing_data'
	];

	public function campaign()
	{
		return $this->belongsTo(\App\Models\Campaign::class, 'campaing_id');
	}

	public function donor()
	{
		return $this->belongsTo(\App\Models\Donor::class);
	}

	public function services_list()
	{
		return $this->belongsTo(\App\Models\ServicesList::class, 'service_id');
	}
}
