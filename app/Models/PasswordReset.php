<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;



/**
 * Class PasswordReset
 *
 * 
 * @property string $email
 *
 * @property string $token
 * Name of the action event. Needs to be one of the names provided in config
 *
 *
 * @property \Carbon\Carbon $created_at
 * 

 *
 * @package App\Models
 */
class PasswordReset extends BaseModel
{
	public $timestamps = false;

	protected $fillable = [
		'email',
		'token',
	];
}
