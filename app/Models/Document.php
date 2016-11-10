<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;



/**
 * Class Document
 * Documents are all documents we use on the site for verification of delivery, bank statement...EVERYTHING
 * They all need to be archived
 * 
 * @property int $id
 * @property int $organization_id
 * Id of owner organization
 *
 * @property int $person_id
 * Id or the person if it relates to a person
 *
 * @property int $donor_id
 * Id of donor if it relates to donor
 *
 * @property string $type
 * Type of document
 *
 * @property string $reference
 * Reference from the document if present
 *
 * @property \Carbon\Carbon $created_at
 * 
 * @property \App\Models\Donor $donor
 * @property \App\Models\Organization $organization
 * @property \App\Models\Person $person
 * @property \Illuminate\Database\Eloquent\Collection $media_links
 *
 * @package App\Models
 */
class Document extends BaseModel
{
	public $timestamps = false;

	protected $casts = [
		'organization_id' => 'int',
		'person_id' => 'int',
		'donor_id' => 'int'
	];

	protected $fillable = [
		'organization_id',
		'person_id',
		'donor_id',
		'type',
		'reference'
	];

	public function donor()
	{
		return $this->belongsTo(\App\Models\Donor::class);
	}

	public function organization()
	{
		return $this->belongsTo(\App\Models\Organization::class);
	}

	public function person()
	{
		return $this->belongsTo(\App\Models\Person::class);
	}

	public function media_links()
	{
		return $this->hasMany(\App\Models\MediaLink::class);
	}
}
