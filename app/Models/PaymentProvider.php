<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;



/**
 * Class PaymentProvider
 * List of payment provider
 * 
 * @property int $id
 * @property string $name
 * Name of service provider
 *
 * @property string $key
 * Authentication key for provider
 *
 * @property string $api_uri
 * Api endpoint to use
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $modified_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $payment_provider_data
 *
 * @package App\Models
 */
class PaymentProvider extends BaseModel
{
	public $timestamps = false;

	protected $dates = [
		'modified_at'
	];

	protected $fillable = [
		'name',
		'key',
		'api_uri',
		'modified_at'
	];

	public function payment_provider_data()
	{
		return $this->hasMany(\App\Models\PaymentProviderDatum::class, 'provider_id');
	}
}
