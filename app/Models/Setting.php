<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;



/**
 * Class Setting
 *
 * @property string $key
 * @property string $value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $modified_at
 *
 * @package App\Models
 */
class Setting extends BaseModel
{
	public $timestamps = false;
	protected $primaryKey = 'key';
	public $incrementing = false;

	protected $dates = [
		'modified_at'
	];

	protected $fillable = [
		'key',
		'value',
		'modified_at'
	];


	public static function getSetting($key)
	{
		return self::whereKey($key)->get()->first();
	}
}
