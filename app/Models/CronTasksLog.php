<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CronTasksLog
 * 
 * @property int $id
 * @property string $name
 * @property string $action
 * @property string $params
 * @property string $output
 *
 * @package App\Models
 */
class CronTasksLog extends Eloquent
{
	protected $table = 'cron_tasks_log';
	public $timestamps = false;

	protected $fillable = [
		'name',
		'action',
		'params',
		'output'
	];
}
