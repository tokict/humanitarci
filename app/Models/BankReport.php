<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;



/**
 * Class BankReport
 * 
 * @property int $id
 *
 * @property int $bank_id
 *
 * @property int $organization_id
 * Name of the payee as it appears on the bank statement
 *
 * @property string $filename
 * Donor id form payment description. It should not accept values not found as in in donors table
 *
 *
 * @property \Carbon\Carbon $processed_at
 * @property \Carbon\Carbon $received_at
 *
 *
 * @property Bank $bank
 * @property Organization $organization
 *
 *
 * @package App\Models
 */
class BankReport extends BaseModel
{
	public $timestamps = false;

	protected $casts = [
		'organization_id' => 'int',
        'bank_id' => 'int'
	];

	protected $dates = [
		'processed_at',
        'received_at'
	];

	protected $fillable = [
		'organization_id',
		'bank_id',
		'filename',
		'processed_at',
		'received_at'
	];


	public function bank()
	{
		return $this->belongsTo(\App\Models\Bank::class);
	}

	public function organization()
	{
		return $this->belongsTo(\App\Models\Organization::class);
	}

}
