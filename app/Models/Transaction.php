<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;



/**
 * Class Transaction
 * Transactions manage moving stuff between campaigns.
 * They ABSOLUTELY MUST be done with transactions in mysql. After the donation is created, we need to put its id
 * into the transaction data
 * 
 * @property int $id
 * @property int $from_donation_id
 * We are taking stuff from this donation
 *
 * @property int $donation_id
 * We are have created a donation and put the stuff in this donation_id
 *
 * @property int $amount
 * We took this amount
 *
 * @property string $goods
 * We took this amount of goods
 *
 * @property \Carbon\Carbon $time
 *
 * @property string $type
 *
 * @property string $description
 * Description for reason of transfer
 *
 * @property int $campaign_id
 * The donation was meant for this campaign
 * 
 * @property \App\Models\Campaign $campaign
 * @property \App\Models\Donation $donation
 * @property \Illuminate\Database\Eloquent\Collection $donations
 *
 * @package App\Models
 */
class Transaction extends BaseModel
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
