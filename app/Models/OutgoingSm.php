<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class OutgoingSm
 * 
 * @property int $id
 * @property int $person_id
 * @property int $organization_id
 * @property int $donor_id
 * @property int $group_id
 * @property int $legal_entity_id
 * @property string $body
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $sent_at
 * 
 * @property \App\Models\Donor $donor
 * @property \App\Models\Group $group
 * @property \App\Models\LegalEntity $legal_entity
 * @property \App\Models\Organization $organization
 * @property \App\Models\Person $person
 *
 * @package App\Models
 */
class OutgoingSm extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'person_id' => 'int',
		'organization_id' => 'int',
		'donor_id' => 'int',
		'group_id' => 'int',
		'legal_entity_id' => 'int'
	];

	protected $dates = [
		'sent_at'
	];

	protected $fillable = [
		'person_id',
		'organization_id',
		'donor_id',
		'group_id',
		'legal_entity_id',
		'body',
		'sent_at'
	];

	public function donor()
	{
		return $this->belongsTo(\App\Models\Donor::class);
	}

	public function group()
	{
		return $this->belongsTo(\App\Models\Group::class);
	}

	public function legal_entity()
	{
		return $this->belongsTo(\App\Models\LegalEntity::class);
	}

	public function organization()
	{
		return $this->belongsTo(\App\Models\Organization::class);
	}

	public function person()
	{
		return $this->belongsTo(\App\Models\Person::class);
	}
}
