<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class BeneficiaryReport
 * 
 * @property int $id
 * @property int $beneficiary_id
 * @property string $type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $start_time
 * @property string $data
 * 
 * @property \App\Models\Beneficiary $beneficiary
 *
 * @package App\Models
 */
class BeneficiaryReport extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'beneficiary_id' => 'int'
	];

	protected $dates = [
		'start_time'
	];

	protected $fillable = [
		'beneficiary_id',
		'type',
		'start_time',
		'data'
	];

	public function beneficiary()
	{
		return $this->belongsTo(\App\Models\Beneficiary::class);
	}
}
