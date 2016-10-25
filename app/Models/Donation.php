<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Donation
 * 
 * @property int $id
 * @property int $beneficiary_id
 * @property int $campaign_id
 * @property int $donor_id
 * @property string $type
 * @property int $amount
 * @property string $status
 * @property \Carbon\Carbon $created_date
 * @property string $payment_reference_used
 * @property string $source
 * @property string $goods
 * @property int $payment_id
 * @property int $transaction_id
 * @property int $goods_received_id
 * @property int $service_id
 * @property bool $service_delivered
 * @property int $organization_id
 * 
 * @property \App\Models\Beneficiary $beneficiary
 * @property \App\Models\Campaign $campaign
 * @property \App\Models\Donor $donor
 * @property \App\Models\GoodsInput $goods_input
 * @property \App\Models\Organization $organization
 * @property \App\Models\MonetaryInput $monetary_input
 * @property \App\Models\ServicesList $services_list
 * @property \App\Models\Transaction $transaction
 * @property \Illuminate\Database\Eloquent\Collection $transactions
 *
 * @package App\Models
 */
class Donation extends Eloquent
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
		'created_date'
	];

	protected $fillable = [
		'beneficiary_id',
		'campaign_id',
		'donor_id',
		'type',
		'amount',
		'status',
		'created_date',
		'payment_reference_used',
		'source',
		'goods',
		'payment_id',
		'transaction_id',
		'goods_received_id',
		'service_id',
		'service_delivered',
		'organization_id'
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
}
