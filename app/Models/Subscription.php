<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Subscription
 * 
 * @property int $id
 * @property int $donor_id
 * @property int $campaing_id
 * @property int $amount
 * @property int $service_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $modified_at
 * @property string $status
 * @property string $processing_data
 * 
 * @property \App\Models\Campaign $campaign
 * @property \App\Models\Donor $donor
 * @property \App\Models\ServicesList $services_list
 *
 * @package App\Models
 */
class Subscription extends Eloquent
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
