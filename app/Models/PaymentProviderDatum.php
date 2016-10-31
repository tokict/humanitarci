<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PaymentProviderDatum
 * Data related to payment providers and payments. Callbackd data etc
 * 
 * @property int $id
 * @property int $subscription_id
 * @property int $provider_id
 * 
 * @property \App\Models\PaymentProvider $payment_provider
 * @property \Illuminate\Database\Eloquent\Collection $monetary_inputs
 *
 * @package App\Models
 */
class PaymentProviderDatum extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'subscription_id' => 'int',
		'provider_id' => 'int'
	];

	protected $fillable = [
		'subscription_id',
		'provider_id'
	];

	public function payment_provider()
	{
		return $this->belongsTo(\App\Models\PaymentProvider::class, 'provider_id');
	}

	public function monetary_inputs()
	{
		return $this->hasMany(\App\Models\MonetaryInput::class, 'payment_provider_data_id');
	}
}
