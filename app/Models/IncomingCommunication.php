<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;



/**
 * Class IncomingCommunication
 * 
 * @property int $id
 * @property string $type
 * @property string $subject
 * @property string $body
 * @property string $attachments
 * @property string $mail_to
 * @property string $mail_from
 * @property string $msisdn_from
 * @property int $device_id_from
 * 
 * @property \App\Models\Device $device
 *
 * @package App\Models
 */
class IncomingCommunication extends BaseModel
{
	protected $table = 'incoming_communication';
	public $timestamps = false;

	protected $casts = [
		'device_id_from' => 'int'
	];

	protected $fillable = [
		'type',
		'subject',
		'body',
		'attachments',
		'mail_to',
		'mail_from',
		'msisdn_from',
		'device_id_from'
	];

	public function device()
	{
		return $this->belongsTo(\App\Models\Device::class, 'device_id_from');
	}
}
