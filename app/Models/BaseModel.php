<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

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
	}


}
