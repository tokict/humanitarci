<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

/**
 * Class Beneficiary
 * This class handles public data that is to be presented to donors. It is a counterpart to donations class. So, donation goes to the beneficiary
 *
 * 
 * @property int $id
 *
 * @property string $name
 * 	Name MUST NOT be edited after first campaign is created and activated for this beneficiary to prevent manipulations
 *
 * @property string $identifier
 * 	Identifier is to be used with bank transfers as reference numbers, track input documents related to specific beneficiary etc.
 *
 * @property int $profile_image_id
 * 	Profile image is the current image set to be associated with beneficiary in all publications (widgets, campaigns, cards)
 *
 * @property int $funds_used
 * 	Total amount of funds transferred from this platform to beneficiary. Is updated ONLY by admin and ONLY when he marks the donations as transferred
 * 	This action should be accompanied with signed documents from the benefactor and other actions linked to that activity
 *
 * @property int $donor_number
 * 	The amount of unique people/entities who donated to this beneficiary. Updated ONLY when admin transfers the donations as above
 *
 * @property string $status
 * Status of beneficiary in the system
 *
 * @property int $person_id
 * If beneficiary is a person, this is his person id
 *
 * @property int $entity_id
 * If beneficiary is a legal entity, this is his legal entity id
 *
 * @property string $contact_phone
 * Ditto..
 *
 * @property string $contact_mail
 * Ditto..
 *
 * @property int $created_by_id
 * Id of the admin who created this in the system
 *
 * @property string $description
 * Description of the beneficiary. This should be the story about the person / entity and it should provoke empathy
 *
 * @property int $members_public
 * Whether the members of the group are to be available to public
 *
 * @property string $photo_ids
 *	Serialized array of photos associated with this beneficiary from media table
 *
 * @property int $group_id
 * If this beneficiary is a group of people or entities, this is the group id. This MUST not be edited after first active campaign
 * 
 * @property \App\Models\LegalEntity $entity
 * LegalEntity object belonging to this beneficiary
 *
 * @property \App\Models\Person $person
 *
 * @property \App\Models\Admin $creator
 * Admin object belonging to this beneficiary
 *
 * @property \App\Models\Group $group
 * Group object belonging to this beneficiary
 *
 *
 * @property \Illuminate\Database\Eloquent\Collection $beneficiary_reports
 * Reports collection for this beneficiary
 *
 * @property \Illuminate\Database\Eloquent\Collection $campaigns
 * Campaigns collection made for this beneficiary
 *
 * @property \Illuminate\Database\Eloquent\Collection $donations
 * Donations collection donated to this beneficiary
 *
 * @property \Illuminate\Database\Eloquent\Collection $media_links
 * Media links collection tied to this beneficiary
 *
 * @package App\Models
 */
class Beneficiary extends BaseModel
{
	public $timestamps = false;

	protected $casts = [
		'profile_image_id' => 'int',
		'group_id' => 'int',
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
		'group_id' => 'int',
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

	public function entity()
	{
		return $this->belongsTo(\App\Models\LegalEntity::class, 'entity_id');
	}

	public function creator()
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

	public function person(){
		return $this->belongsTo(\App\Models\Person::class, 'person_id');
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
