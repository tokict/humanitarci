<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ServicesList
 * 
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $cover_image_url
 * 
 * @property \Illuminate\Database\Eloquent\Collection $donations
 * @property \Illuminate\Database\Eloquent\Collection $subscriptions
 *
 * @package App\Models
 */
class ServicesList extends Eloquent
{
	protected $table = 'services_list';
	public $timestamps = false;

	protected $fillable = [
		'name',
		'description',
		'cover_image_url'
	];

	public function donations()
	{
		return $this->hasMany(\App\Models\Donation::class, 'service_id');
	}

	public function subscriptions()
	{
		return $this->hasMany(\App\Models\Subscription::class, 'service_id');
	}
}
