<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Bank
 * This class is referenced when specifying a bank in the system
 * 
 * @property int $id
 *
 * @property string $name
 * Formal full name of the bank
 *
 * @property string $swift_code
 * Swift code of the bank
 *
 * @property \App\Models\LegalEntity $legalEntity
 *
 * 
 *
 *
 * @package App\Models
 */
class Bank extends Eloquent
{
	public $timestamps = false;

	protected $fillable = [
		'name',
		'swift_code',
		'legal_entity_id'
	];


	public function legalEntity()
	{
		return $this->belongsTo(\App\Models\LegalEntity::class);
	}

}
