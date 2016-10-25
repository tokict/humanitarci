<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Bank
 * 
 * @property int $id
 * @property string $name
 * @property string $swift_code
 * @property string $address_line
 * 
 * @property \Illuminate\Database\Eloquent\Collection $people
 *
 * @package App\Models
 */
class Bank extends Eloquent
{
	public $timestamps = false;

	protected $fillable = [
		'name',
		'swift_code',
		'address_line'
	];

	public function people()
	{
		return $this->hasMany(\App\Models\Person::class);
	}
}
