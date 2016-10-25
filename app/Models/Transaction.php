<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Transaction
 * 
 * @property int $id
 * @property int $from_donation_id
 * @property int $donation_id
 * @property int $amount
 * @property string $goods
 * @property \Carbon\Carbon $time
 * @property string $type
 * @property string $description
 * @property int $campaign_id
 * 
 * @property \App\Models\Campaign $campaign
 * @property \App\Models\Donation $donation
 * @property \Illuminate\Database\Eloquent\Collection $donations
 *
 * @package App\Models
 */
class Transaction extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'from_donation_id' => 'int',
		'donation_id' => 'int',
		'amount' => 'int',
		'campaign_id' => 'int'
	];

	protected $dates = [
		'time'
	];

	protected $fillable = [
		'from_donation_id',
		'donation_id',
		'amount',
		'goods',
		'time',
		'type',
		'description',
		'campaign_id'
	];

	public function campaign()
	{
		return $this->belongsTo(\App\Models\Campaign::class);
	}

	public function donation()
	{
		return $this->belongsTo(\App\Models\Donation::class, 'from_donation_id');
	}

	public function donations()
	{
		return $this->hasMany(\App\Models\Donation::class);
	}
}
