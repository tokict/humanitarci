<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class BeneficiaryReport
 * This class handles reports for the beneficiary. This data is primarily public.
 * Data should have simple formatting so it can be merged and reprocessed with other beneficiaries to make summaries
 *
 * 
 * @property int $id
 *
 * @property int $beneficiary_id
 * id of the beneficiary this report belogns to
 *
 * @property string $type
 * Type of report
 *
 *
 * @property \Carbon\Carbon $created_at
 *
 * @property \Carbon\Carbon $start_time
 * Start time is the index at which data was taken into account. I.e 2016-27-10 would mark that the data if
 * from midnight on this date and based on type it encases the next day, week etc..
 *
 * @property string $data
 * Serialized array of processed data
 * 
 * @property \App\Models\Beneficiary $beneficiary
 * Beneficiary object connected to this report
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
