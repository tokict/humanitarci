<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Admin
 * 
 * @property int $id
 * @property int $person_id
 * @property int $organization_id
 * @property string $password
 * 
 * @property \App\Models\Organization $organization
 * @property \App\Models\Person $person
 * @property \Illuminate\Database\Eloquent\Collection $action_logs
 * @property \Illuminate\Database\Eloquent\Collection $beneficiaries
 * @property \Illuminate\Database\Eloquent\Collection $campaigns
 *
 * @package App\Models
 */
class Admin extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'person_id' => 'int',
		'organization_id' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'person_id',
		'organization_id',
		'password'
	];

	public function organization()
	{
		return $this->belongsTo(\App\Models\Organization::class);
	}

	public function person()
	{
		return $this->belongsTo(\App\Models\Person::class);
	}

	public function action_logs()
	{
		return $this->hasMany(\App\Models\ActionLog::class, 'id_admin');
	}

	public function beneficiaries()
	{
		return $this->hasMany(\App\Models\Beneficiary::class, 'created_by_id');
	}

	public function campaigns()
	{
		return $this->hasMany(\App\Models\Campaign::class, 'administrator_id');
	}
}
