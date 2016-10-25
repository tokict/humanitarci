<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class GoodsList
 * 
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $unit_measurement
 * @property string $cover_image_url
 *
 * @package App\Models
 */
class GoodsList extends Eloquent
{
	protected $table = 'goods_list';
	public $timestamps = false;

	protected $fillable = [
		'name',
		'description',
		'unit_measurement',
		'cover_image_url'
	];
}
