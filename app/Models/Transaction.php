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
 * @property int $from_campaign_id
 * The donation was meant for this campaign
 *
 * @property int $to_campaign_id
 * Money was transferred from this campaign
 * 
 * @property \App\Models\Campaign $campaign
 * @property \App\Models\Donation $from_donation
 * @property \App\Models\Donation $to_donation
 *
 * @package App\Models
 */
class Transaction extends BaseModel
{
	public $timestamps = false;

	protected $casts = [
		'from_donation_id' => 'int',
		'to_donation_id' => 'int',
		'amount' => 'int',
		'from_campaign_id' => 'int',
		'to_campaign_id' => 'int'
	];

	protected $dates = [
		'time'
	];

	protected $fillable = [
		'from_donation_id',
		'to_donation_id',
		'amount',
		'goods',
		'time',
		'type',
		'description',
		'from_campaign_id',
		'to_campaign_id'
	];

	public function from_campaign()
	{
		return $this->belongsTo(\App\Models\Campaign::class);
	}

	public function to_campaign()
	{
		return $this->belongsTo(\App\Models\Campaign::class);
	}

	public function from_donation()
	{
		return $this->belongsTo(\App\Models\Donation::class, 'from_donation_id');
	}

	public function to_donation()
	{
		return $this->belongsTo(\App\Models\Donation::class, 'to_donation_id');
	}

}
