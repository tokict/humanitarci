<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class GoodsList
 * A list of all goods we use to track physical donations
 * 
 * @property int $id
 * @property string $name
 * Name of item
 * @property string $description
 * Descritpion
 * @property string $unit_measurement
 * @property string $cover_image_url
 * A generic image for easier recognition
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
