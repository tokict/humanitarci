<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Person
 * Person and its counterpart, legal_entity are the base objects from which all starts.
 * 
 * @property int $id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $social_id
 * @property int $city_id
 * @property string $address
 * @property string $contact_phone
 * @property string $contact_email
 * @property string $social_accounts
 * @property string $gender
 * @property string $title
 * @property bool $is_donor
 * @property bool $is_beneficiary
 * @property bool $is_admin
 * @property int $bank_id
 * @property string $bank_acc
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $modified_at
 * @property int $device_id
 * 
 * @property \App\Models\Bank $bank
 * @property \App\Models\City $city
 * @property \App\Models\Device $device
 * @property \Illuminate\Database\Eloquent\Collection $admins
 * @property \Illuminate\Database\Eloquent\Collection $documents
 * @property \Illuminate\Database\Eloquent\Collection $groups
 * @property \Illuminate\Database\Eloquent\Collection $media_links
 * @property \Illuminate\Database\Eloquent\Collection $outgoing_mails
 * @property \Illuminate\Database\Eloquent\Collection $outgoing_pushes
 * @property \Illuminate\Database\Eloquent\Collection $outgoing_sms
 *
 * @package App\Models
 */
class Person extends Eloquent
{
	protected $table = 'persons';
	public $timestamps = false;

	protected $casts = [
		'city_id' => 'int',
		'is_donor' => 'bool',
		'is_beneficiary' => 'bool',
		'is_admin' => 'bool',
		'bank_id' => 'int',
		'device_id' => 'int'
	];

	protected $dates = [
		'modified_at'
	];

	protected $fillable = [
		'first_name',
		'middle_name',
		'last_name',
		'social_id',
		'city_id',
		'address',
		'contact_phone',
		'contact_email',
		'social_accounts',
		'gender',
		'title',
		'is_donor',
		'is_beneficiary',
		'is_admin',
		'bank_id',
		'bank_acc',
		'modified_at',
		'device_id'
	];

	public function bank()
	{
		return $this->belongsTo(\App\Models\Bank::class);
	}

	public function city()
	{
		return $this->belongsTo(\App\Models\City::class);
	}

	public function device()
	{
		return $this->belongsTo(\App\Models\Device::class);
	}

	public function admins()
	{
		return $this->hasMany(\App\Models\Admin::class);
	}

	public function documents()
	{
		return $this->hasMany(\App\Models\Document::class);
	}

	public function groups()
	{
		return $this->hasMany(\App\Models\Group::class, 'representing_person_id');
	}

	public function media_links()
	{
		return $this->hasMany(\App\Models\MediaLink::class);
	}

	public function outgoing_mails()
	{
		return $this->hasMany(\App\Models\OutgoingMail::class);
	}

	public function outgoing_pushes()
	{
		return $this->hasMany(\App\Models\OutgoingPush::class);
	}

	public function outgoing_sms()
	{
		return $this->hasMany(\App\Models\OutgoingSms::class);
	}
}
