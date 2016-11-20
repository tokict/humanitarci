<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class BaseModel
 * @package App\Models
 */
class BaseModel extends Eloquent
{
	public static function boot()
	{
		parent::boot();

		static::creating(function($model) {

			foreach ($model->toArray() as $name => $value) {
				if ($value == "") {
					$model->{$name} = null;
				}
			}
			return true;

		});

		static::updating(function($model) {

			foreach ($model->toArray() as $name => $value) {
				if ($value == "") {
					$model->{$name} = null;
				}
			}
			return true;

		});
	}

	public function setAtt($name, $value)
	{
		$this->attributes[$name] = $value;
	}

	public function getAtt($name)
	{
		return isset($this->attributes[$name])?$this->attributes[$name]:false;
	}

	public function getEnumValues($column) {
		$type = DB::select(DB::raw("SHOW COLUMNS FROM ".$this->getTable()." WHERE Field = '{$column}'"))[0]->Type ;
		preg_match('/^enum\((.*)\)$/', $type, $matches);
		$enum = array();
		foreach( explode(',', $matches[1]) as $value )
		{
			$v = trim( $value, "'" );
			$enum = array_add($enum, $v, ucfirst($v));
		}
		return $enum;
	}


}
