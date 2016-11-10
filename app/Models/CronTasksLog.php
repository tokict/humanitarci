<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;



/**
 * Class CronTasksLog
 * 
 * @property int $id
 * @property string $name
 * Name of the cron task run
 * @property string $action
 * Action performed
 * @property string $params
 * Params sent to the app
 * @property string $output
 * Return of the action
 *
 * @package App\Models
 */
class CronTasksLog extends BaseModel
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
