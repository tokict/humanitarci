<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;



/**
 * Class ActionLog
 * This class handles all logging of actions on the system. It should use events to get them
 * 
 * @property int $id
 *
 * @property string $action_name
 * Name of the action event. Needs to be one of the names provided in config
 *
 *
 * @property int $id_admin
 * If the event is initiated by admin, this is the admin id
 *
 * @property int $donor_id
 * If the event is initiated by donor, this is the donor id
 *
 * @property string $params
 * Params from the event to save for archiving. Serialized array
 *
 * @property \Carbon\Carbon $created_at
 * 
 * @property \App\Models\Donor $donor
 * Donor object associated with entry
 *
 * @property \App\Models\User $user
 * Admin object associated with entry
 *
 * @package App\Models
 */
class ActionLog extends BaseModel
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

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class, 'id_user');
	}
}
