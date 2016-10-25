<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Region
 * 
 * @property int $id
 * @property string $name
 * 
 * @property \Illuminate\Database\Eloquent\Collection $cities
 *
 * @package App\Models
 */
class Region extends Eloquent
{
	public $timestamps = false;

	protected $fillable = [
		'name'
	];

	public function cities()
	{
		return $this->hasMany(\App\Models\City::class);
	}
}
