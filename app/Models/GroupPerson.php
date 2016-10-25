<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class GroupPerson
 * 
 * @property int $person_id
 * @property int $group_id
 * @property \Carbon\Carbon $added_at
 * @property \Carbon\Carbon $modified_at
 * @property string $status
 * 
 * @property \App\Models\Group $group
 * @property \App\Models\Person $person
 *
 * @package App\Models
 */
class GroupPerson extends Eloquent
{
	protected $table = 'group_persons';
	protected $primaryKey = 'person_id';
	public $timestamps = false;

	protected $casts = [
		'group_id' => 'int'
	];

	protected $dates = [
		'added_at',
		'modified_at'
	];

	protected $fillable = [
		'group_id',
		'added_at',
		'modified_at',
		'status'
	];

	public function group()
	{
		return $this->belongsTo(\App\Models\Group::class);
	}

	public function person()
	{
		return $this->belongsTo(\App\Models\Person::class);
	}
}
