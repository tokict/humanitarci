<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Beneficiary
 * 
 * @property int $id
 * @property string $name
 * 	Name cannot be edited after first campaign is created and activated for this beneficiary to prevent manipulations
 * @property string $identifier
 * 	Identifier is to use with bank transfers as reference numbers, track input documents related to specific beneficiary etc.
 * @property int $profile_image_id
 * @property int $funds_used
 * @property int $donor_number
 * @property string $status
 * @property int $person_id
 * @property int $entity_id
 * @property string $contact_phone
 * @property string $contact_mail
 * @property int $created_by_id
 * @property string $description
 * @property int $members_public
 * @property string $photo_ids
 * @property int $company_id
 * 
 * @property \App\Models\LegalEntity $legal_entity
 * @property \App\Models\Admin $admin
 * @property \App\Models\Group $group
 * @property \Illuminate\Database\Eloquent\Collection $beneficiary_reports
 * @property \Illuminate\Database\Eloquent\Collection $campaigns
 * @property \Illuminate\Database\Eloquent\Collection $donations
 * @property \Illuminate\Database\Eloquent\Collection $media_links
 *
 * @package App\Models
 */
class Beneficiary extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'profile_image_id' => 'int',
		'funds_used' => 'int',
		'donor_number' => 'int',
		'person_id' => 'int',
		'entity_id' => 'int',
		'created_by_id' => 'int',
		'members_public' => 'int',
		'company_id' => 'int'
	];

	protected $fillable = [
		'name',
		'identifier',
		'profile_image_id',
		'funds_used',
		'donor_number',
		'status',
		'person_id',
		'entity_id',
		'contact_phone',
		'contact_mail',
		'created_by_id',
		'description',
		'members_public',
		'photo_ids',
		'company_id'
	];

	public function legal_entity()
	{
		return $this->belongsTo(\App\Models\LegalEntity::class, 'company_id');
	}

	public function admin()
	{
		return $this->belongsTo(\App\Models\Admin::class, 'created_by_id');
	}

	public function group()
	{
		return $this->belongsTo(\App\Models\Group::class);
	}

	public function beneficiary_reports()
	{
		return $this->hasMany(\App\Models\BeneficiaryReport::class);
	}

	public function campaigns()
	{
		return $this->hasMany(\App\Models\Campaign::class);
	}

	public function donations()
	{
		return $this->hasMany(\App\Models\Donation::class);
	}

	public function media_links()
	{
		return $this->hasMany(\App\Models\MediaLink::class);
	}
}
