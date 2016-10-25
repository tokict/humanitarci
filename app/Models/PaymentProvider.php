<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PaymentProvider
 * 
 * @property int $id
 * @property string $name
 * @property string $key
 * @property string $api_uri
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $modified_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $payment_provider_data
 *
 * @package App\Models
 */
class PaymentProvider extends Eloquent
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
