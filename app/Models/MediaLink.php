<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MediaLink
 * 
 * @property int $id
 * @property int $document_id
 * @property int $campaign_id
 * @property int $media_id
 * @property int $organization_id
 * @property int $person_id
 * @property int $donor_id
 * @property int $beneficiary_id
 * 
 * @property \App\Models\Beneficiary $beneficiary
 * @property \App\Models\Campaign $campaign
 * @property \App\Models\Document $document
 * @property \App\Models\Donor $donor
 * @property \App\Models\Medium $medium
 * @property \App\Models\Organization $organization
 * @property \App\Models\Person $person
 *
 * @package App\Models
 */
class MediaLink extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'document_id' => 'int',
		'campaign_id' => 'int',
		'media_id' => 'int',
		'organization_id' => 'int',
		'person_id' => 'int',
		'donor_id' => 'int',
		'beneficiary_id' => 'int'
	];

	protected $fillable = [
		'document_id',
		'campaign_id',
		'media_id',
		'organization_id',
		'person_id',
		'donor_id',
		'beneficiary_id'
	];

	public function beneficiary()
	{
		return $this->belongsTo(\App\Models\Beneficiary::class);
	}

	public function campaign()
	{
		return $this->belongsTo(\App\Models\Campaign::class);
	}

	public function document()
	{
		return $this->belongsTo(\App\Models\Document::class);
	}

	public function donor()
	{
		return $this->belongsTo(\App\Models\Donor::class);
	}

	public function medium()
	{
		return $this->belongsTo(\App\Models\Medium::class, 'media_id');
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
