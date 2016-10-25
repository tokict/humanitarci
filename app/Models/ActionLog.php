<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ActionLog
 * 
 * @property int $id
 * @property string $action_name
 * @property int $id_admin
 * @property int $donor_id
 * @property string $params
 * @property \Carbon\Carbon $created_at
 * 
 * @property \App\Models\Donor $donor
 * @property \App\Models\Admin $admin
 *
 * @package App\Models
 */
class ActionLog extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'id_admin' => 'int',
		'donor_id' => 'int'
	];

	protected $fillable = [
		'action_name',
		'id_admin',
		'donor_id',
		'params'
	];

	public function donor()
	{
		return $this->belongsTo(\App\Models\Donor::class);
	}

	public function admin()
	{
		return $this->belongsTo(\App\Models\Admin::class, 'id_admin');
	}
}
