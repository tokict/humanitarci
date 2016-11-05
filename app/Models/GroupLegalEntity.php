<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class GroupLegalEntity
 * 
 * @property int $legal_entity_id
 * @property int $group_id
 * @property \Carbon\Carbon $added_at
 * @property \Carbon\Carbon $modified_at
 * @property string $status
 * 
 * @property \App\Models\Group $group
 * @property \App\Models\LegalEntity $legal_entity
 *
 * @package App\Models
 */
class GroupLegalEntity extends Eloquent
{
	protected $primaryKey = 'legal_entity_id';
	public $timestamps = false;

	protected $casts = [
		'group_id' => 'int'
	];

	protected $dates = [
		'added_at',
		'modified_at'
	];

	protected $fillable = [
		'group_id',
		'added_at',
		'modified_at',
		'status'
	];

	public function group()
	{
		return $this->belongsTo(\App\Models\Group::class);
	}

	public function legal_entity()
	{
		return $this->belongsTo(\App\Models\LegalEntity::class);
	}
}
