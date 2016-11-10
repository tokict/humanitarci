<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;



/**
 * Class DonorReport
 * 
 * @property int $id
 * @property int $donor_id
 * @property string $type
 * @property \Carbon\Carbon $start_time
 * @property \Carbon\Carbon $created_at
 * @property string $donator_reportscol
 * 
 * @property \App\Models\Donor $donor
 *
 * @package App\Models
 */
class DonorReport extends BaseModel
{
	public $timestamps = false;

	protected $casts = [
		'donor_id' => 'int'
	];

	protected $dates = [
		'start_time'
	];

	protected $fillable = [
		'donor_id',
		'type',
		'start_time',
		'donator_reportscol'
	];

	public function donor()
	{
		return $this->belongsTo(\App\Models\Donor::class);
	}
}
