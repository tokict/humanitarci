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
 * @property string $key
 * @property string $value
 * @property string $language
 * 
 * 
 *
 * @package App\Models
 */
class Language extends Eloquent
{
	public $timestamps = false;
	protected $table = 'languages';
	protected $fillable = [
		'key', 'value', 'language'
	];

}
