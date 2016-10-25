<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PlatformReport
 * 
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property string $type
 * @property \Carbon\Carbon $start_time
 * @property string $data
 *
 * @package App\Models
 */
class PlatformReport extends Eloquent
{
	public $timestamps = false;

	protected $dates = [
		'start_time'
	];

	protected $fillable = [
		'type',
		'start_time',
		'data'
	];
}
