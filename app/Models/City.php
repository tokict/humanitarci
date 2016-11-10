<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;



/**
 * Class City
 * 
 * @property int $id
 * @property string $name
 * @property int $region_id
 *
 *
 * 
 * @property \App\Models\Region $region
 * @property \Illuminate\Database\Eloquent\Collection $people
 *
 * @package App\Models
 */
class City extends BaseModel
{
	public $timestamps = false;

	protected $casts = [
		'region_id' => 'int'
	];

	protected $fillable = [
		'name',
		'region_id'
	];

	public function region()
	{
		return $this->belongsTo(\App\Models\Region::class);
	}

	public function people()
	{
		return $this->hasMany(\App\Models\Person::class);
	}
}
