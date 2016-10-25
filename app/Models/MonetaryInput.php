<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MonetaryInput
 * 
 * @property int $id
 * @property int $donor_id
 * @property int $amount
 * @property \Carbon\Carbon $created_at
 * @property int $campaign_id
 * @property int $payment_provider_data_id
 * @property int $bank_transfer_data_id
 * 
 * @property \App\Models\BankTransfersDatum $bank_transfers_datum
 * @property \App\Models\Campaign $campaign
 * @property \App\Models\Donor $donor
 * @property \App\Models\PaymentProviderDatum $payment_provider_datum
 * @property \Illuminate\Database\Eloquent\Collection $donations
 *
 * @package App\Models
 */
class MonetaryInput extends Eloquent
{
	protected $table = 'monetary_input';
	public $timestamps = false;

	protected $casts = [
		'donor_id' => 'int',
		'amount' => 'int',
		'campaign_id' => 'int',
		'payment_provider_data_id' => 'int',
		'bank_transfer_data_id' => 'int'
	];

	protected $fillable = [
		'donor_id',
		'amount',
		'campaign_id',
		'payment_provider_data_id',
		'bank_transfer_data_id'
	];

	public function bank_transfers_datum()
	{
		return $this->belongsTo(\App\Models\BankTransfersDatum::class, 'bank_transfer_data_id');
	}

	public function campaign()
	{
		return $this->belongsTo(\App\Models\Campaign::class);
	}

	public function donor()
	{
		return $this->belongsTo(\App\Models\Donor::class);
	}

	public function payment_provider_datum()
	{
		return $this->belongsTo(\App\Models\PaymentProviderDatum::class, 'payment_provider_data_id');
	}

	public function donations()
	{
		return $this->hasMany(\App\Models\Donation::class, 'payment_id');
	}
}
