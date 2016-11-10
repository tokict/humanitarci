<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;



/**
 * Class OrganizationReport
 * 
 * @property int $id
 * @property int $organization_id
 * 
 * @property \App\Models\Organization $organization
 *
 * @package App\Models
 */
class OrganizationReport extends BaseModel
{
	public $timestamps = false;

	protected $casts = [
		'organization_id' => 'int'
	];

	protected $fillable = [
		'organization_id'
	];

	public function organization()
	{
		return $this->belongsTo(\App\Models\Organization::class);
	}
}
