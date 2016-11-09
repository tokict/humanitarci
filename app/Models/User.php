<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;


use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Person
 * Person and its counterpart, legal_entity are the base objects from which all starts.
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $modified_at
 *
 * @property \Illuminate\Database\Eloquent\Collection $admins

 *
 * @package App\Models
 */
class User extends Eloquent
{


	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
	];

	protected $dates = [
		'created_at', 'updated_at'
	];

	protected $fillable = [
		'name',
		'email',
		'password',
		'remember_token',
	];



	public function admins()
	{
		return $this->hasMany(\App\Models\Admin::class);
	}

}
