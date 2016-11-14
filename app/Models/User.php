<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;




/**
 * Class Person
 * Person and its counterpart, legal_entity are the base objects from which all starts.
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string remember_token
 * @property int $created_by
 * @property int $organization_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $modified_at
 *
 * @property \App\Models\Person $person
 * Who is this
 * @property \App\Models\Organization $organization
 *
 * @property \App\Models\User $creator
 *
 * @property \Illuminate\Database\Eloquent\Collection $users

 *
 * @package App\Models
 */
class User extends BaseModel
{


	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'created_by' => 'int',
		'organization_id' => 'int',
	];

	protected $dates = [
		'created_at', 'updated_at'
	];

	protected $fillable = [
		'name',
		'email',
		'password',
		'remember_token',
		'created_by',
		'organization_id'
	];



	public function users()
	{
		return $this->hasMany(\App\Models\User::class);
	}

	public function person()
	{
		return $this->belongsTo(\App\Models\Person::class);
	}

	public function creator()
	{
		return $this->belongsTo(\App\Models\User::class);
	}

	public function organization()
	{
		return $this->belongsTo(\App\Models\Organization::class);
	}

}
