<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;



/**
 * Class Region
 * 
 * @property string $key
 * @property string $value
 * @property string $language
 * 
 *
 *
 * @package App\Models
 */
class Text extends BaseModel
{
	public $timestamps = false;
	protected $table = 'texts';
	protected $fillable = [
		'key', 'value', 'language'
	];

}
