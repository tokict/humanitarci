<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Device
 * 
 * @property int $id
 * @property string $type
 * @property string $reference
 * @property string $last_seen
 * 
 * @property \Illuminate\Database\Eloquent\Collection $incoming_communications
 * @property \Illuminate\Database\Eloquent\Collection $people
 *
 * @package App\Models
 */
class Device extends Eloquent
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
