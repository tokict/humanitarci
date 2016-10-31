<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LegalEntity
 * 
 * @property int $id
 * @property string $name
 * Name of the legal entity
 *
 * @property string $tax_id
 * Tax id of the company in the country of registration
 *
 * @property string $vat_id
 * Vat id if different from tax id
 *
 * @property string $city_id
 * City id of conpany registration
 *
 * @property string $address
 * Company headquarters address
 *
 * @property string $bank_id
 * id ban from banks table
 *
 * @property string $bank_acc
 * Bank account number
 *
 * @property bool $is_beneficiary
 * Is the organization a beneficiary
 *
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $modified_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $beneficiaries
 * @property \App\Models\GroupLegalEntity $group_legal_entity
 * @property \Illuminate\Database\Eloquent\Collection $groups
 * @property \Illuminate\Database\Eloquent\Collection $organizations
 * @property \Illuminate\Database\Eloquent\Collection $outgoing_mails
 * @property \Illuminate\Database\Eloquent\Collection $outgoing_pushes
 * @property \Illuminate\Database\Eloquent\Collection $outgoing_sms
 *
 * @package App\Models
 */
class LegalEntity extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'is_beneficiary' => 'bool'
	];

	protected $dates = [
		'modified_at'
	];

	protected $fillable = [
		'name',
		'tax_id',
		'vat_id',
		'city_id',
		'address',
		'bank_id',
		'bank_acc',
		'is_beneficiary',
		'modified_at'
	];

	public function beneficiaries()
	{
		return $this->hasMany(\App\Models\Beneficiary::class, 'company_id');
	}

	public function group_legal_entity()
	{
		return $this->hasOne(\App\Models\GroupLegalEntity::class);
	}

	public function groups()
	{
		return $this->hasMany(\App\Models\Group::class, 'representing_entity_id');
	}

	public function organizations()
	{
		return $this->hasMany(\App\Models\Organization::class);
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
