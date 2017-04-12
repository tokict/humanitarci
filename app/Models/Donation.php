<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;



/**
 * Class Donation
 * 
 * @property int $id
 * @property int $beneficiary_id
 * Id of the beneficiary
 *
 * @property int $campaign_id
 * Campaign for which donation has been made
 *
 * @property int $donor_id
 * Who donated it
 *
 * @property string $type
 * What's the donation type
 *
 * @property int $amount
 * If monetary donation, whats the amount
 *
 * @property string $status
 * What's the internal status of the donation
 *
 * @property \Carbon\Carbon $created_at
 *
 *
 * @property string $source
 * Shortcut to see where this donations funds came from
 *
 * @property string $goods
 * Serialized array of goods this donation has (From goods table)
 *
 * @property int $payment_id
 * Id of monetary_input
 *
 * @property int $transaction_id
 * Id of transaction in case this donation was made by transfering goods or cash from other donations
 *
 * @property int $goods_received_id
 * Id of goods received that was used to create this donation
 *
 *
 * @property int $service_id
 * Service id if donation is a service
 *
 * @property bool $service_delivered
 * Is the service confirmed as delivered
 *
 * @property bool $anonymous
 *
 * @property int $organization_id
 * Id or the organization that will handle this donation
 * 
 * @property \App\Models\Beneficiary $beneficiary
 * @property \App\Models\Campaign $campaign
 * @property \App\Models\Donor $donor
 * @property \App\Models\GoodsInput $goods_input
 * @property \App\Models\Organization $organization
 * @property \App\Models\MonetaryInput $monetary_input
 * @property \App\Models\ServicesList $services_list
 * @property \App\Models\Transaction $transaction
 * @property \App\Models\MonetaryOutputSource $outputs
 * @property \Illuminate\Database\Eloquent\Collection $transactions
 *
 * @package App\Models
 */
class Donation extends BaseModel
{
	public $timestamps = false;

	protected $casts = [
		'beneficiary_id' => 'int',
		'campaign_id' => 'int',
		'donor_id' => 'int',
		'amount' => 'int',
		'payment_id' => 'int',
		'transaction_id' => 'int',
		'goods_received_id' => 'int',
		'service_id' => 'int',
		'service_delivered' => 'bool',
		'organization_id' => 'int'
	];

	protected $dates = [
		'created_at'
	];

	protected $fillable = [
		'beneficiary_id',
		'campaign_id',
		'donor_id',
		'type',
		'amount',
		'status',
		'created_at',
		'payment_reference_used',
		'source',
		'goods',
		'payment_id',
		'transaction_id',
		'goods_received_id',
		'service_id',
		'service_delivered',
		'organization_id',
		'anonymous'
	];

	public function beneficiary()
	{
		return $this->belongsTo(\App\Models\Beneficiary::class);
	}

	public function campaign()
	{
		return $this->belongsTo(\App\Models\Campaign::class);
	}

	public function donor()
	{
		return $this->belongsTo(\App\Models\Donor::class);
	}

	public function goods_input()
	{
		return $this->belongsTo(\App\Models\GoodsInput::class, 'goods_received_id');
	}

	public function organization()
	{
		return $this->belongsTo(\App\Models\Organization::class);
	}

	public function monetary_input()
	{
		return $this->belongsTo(\App\Models\MonetaryInput::class, 'payment_id');
	}

	public function services_list()
	{
		return $this->belongsTo(\App\Models\ServicesList::class, 'service_id');
	}

	public function transaction()
	{
		return $this->belongsTo(\App\Models\Transaction::class);
	}

	public function transactions()
	{
		return $this->hasMany(\App\Models\Transaction::class, 'from_donation_id');
	}

    public function outputs()
    {
        return $this->hasMany(\App\Models\MonetaryOutputSource::class);
    }

	public function getUtilizedAmount()
	{
		return MonetaryOutputSource::whereDonationId($this->getAtt('id'))->sum('amount');
	}

	public function getFreeAmount()
	{
		return $this->getAtt('amount') - MonetaryOutputSource::whereDonationId($this->getAtt('id'))->sum('amount');
	}
}
