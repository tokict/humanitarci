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
 *
 * @property string $payee_name
 * Name of the payee as it appears on the bank statement
 *
 * @property string $donor_id
 * Donor id form payment description. It should not accept values not found as in in donors table
 *
 * @property string $payee_account
 * Payee account as it appears on the bank statement if available
 *
 * @property \Carbon\Carbon $time
 *
 * @property int $amount
 * Amount as it appears on the bank statement
 *
 * @property string $reference
 * Reference number of our beneficiary that payee has put in the reference field or reason of payment.
 * Input of this in the UI should not accept non existing references but can be empty if the payment is for multiple donations
 *
 * @property \Carbon\Carbon $created_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $monetary_inputs
 * Collection of monetary inputs created from this bank transaction. A person can make one payment for several beneficiaries
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
