<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Group
 *
 * 
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $representing_person_id
 * @property int $representing_entity_id
 * 
 * @property \App\Models\LegalEntity $legal_entity
 * @property \App\Models\Person $person
 * @property \Illuminate\Database\Eloquent\Collection $beneficiaries
 * @property \Illuminate\Database\Eloquent\Collection $group_legal_entities
 * @property \Illuminate\Database\Eloquent\Collection $people
 * @property \Illuminate\Database\Eloquent\Collection $outgoing_mails
 * @property \Illuminate\Database\Eloquent\Collection $outgoing_pushes
 * @property \Illuminate\Database\Eloquent\Collection $outgoing_sms
 *
 * @package App\Models
 */
class Group extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'representing_person_id' => 'int',
		'representing_entity_id' => 'int'
	];

	protected $fillable = [
		'name',
		'description',
		'representing_person_id',
		'representing_entity_id'
	];

	public function legal_entity()
	{
		return $this->belongsTo(\App\Models\LegalEntity::class, 'representing_entity_id');
	}

	public function person()
	{
		return $this->belongsTo(\App\Models\Person::class, 'representing_person_id');
	}

	public function beneficiaries()
	{
		return $this->hasMany(\App\Models\Beneficiary::class);
	}

	public function group_legal_entities()
	{
		return $this->hasMany(\App\Models\GroupLegalEntity::class);
	}

	public function people()
	{
		return $this->belongsToMany(\App\Models\Person::class, 'group_persons')
					->withPivot('added_at', 'modified_at', 'status');
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
		return $this->hasMany(\App\Models\OutgoingSm::class);
	}
}
