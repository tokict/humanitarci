<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class BankTransfersDatum
 * 
 * @property int $id
 * @property string $payee_name
 * @property string $payee_account
 * @property \Carbon\Carbon $time
 * @property int $amount
 * @property string $reference
 * @property \Carbon\Carbon $created_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $monetary_inputs
 *
 * @package App\Models
 */
class BankTransfersDatum extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'amount' => 'int'
	];

	protected $dates = [
		'time'
	];

	protected $fillable = [
		'payee_name',
		'payee_account',
		'time',
		'amount',
		'reference'
	];

	public function monetary_inputs()
	{
		return $this->hasMany(\App\Models\MonetaryInput::class, 'bank_transfer_data_id');
	}
}
