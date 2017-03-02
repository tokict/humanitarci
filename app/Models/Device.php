<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;



/**
 * Class Device
 * Devices are devices used by users of site and cms
 * 
 * @property int $id
 * @property string $type
 * Type of device: 'desktop', 'mobile'
 * @property string $reference
 * Internal device id
 * @property string $last_seen
 * 
 * @property \Illuminate\Database\Eloquent\Collection $incoming_communications
 * @property \Illuminate\Database\Eloquent\Collection $people
 *
 * @package App\Models
 */
class Device extends BaseModel
{
	public $timestamps = false;

	protected $fillable = [
		'type',
		'reference',
		'last_seen'
	];

	public function incoming_communications()
	{
		return $this->hasMany(\App\Models\IncomingCommunication::class, 'device_id_from');
	}

	public function people()
	{
		return $this->hasMany(\App\Models\Person::class);
	}
}
