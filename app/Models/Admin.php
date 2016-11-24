<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;



/**
 * Class Admin
 * Admin is a member of an humanitarian organization or staff of platform. It MUST be connected to a person or organization
 * 
 * @property int $id
 * @property int $user_id
 * @property string $created_at
 * @property int $created_by
 * If the admin is and individual, this is his person id
 *
 * @property int $organization_id
 * If the admin is an organization, this is the organization id
 *
 * @property string $password
 * Encrypted password used for login
 * 
 * @property \App\Models\Organization $organization
 * Organization object associated with entry
 *
 * @property \App\User$user
 * Person object associated with entry
 *
 * @property \App\User$creator
 * Who created it
 *
 * @property \Illuminate\Database\Eloquent\Collection $action_logs
 * Collection of logs for this admin
 *
 * @property \Illuminate\Database\Eloquent\Collection $beneficiaries
 * Collection of beneficiaries created by this admin
 *
 * @property \Illuminate\Database\Eloquent\Collection $campaigns
 * Collection of campaigns created by this admin
 *
 * @package App\Models
 */
class Admin extends BaseModel
{
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'organization_id' => 'int',
		'created_by' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'user_id',
		'organization_id',
		'password',
		'user_id',
		'created_by'

	];

	public function organization()
	{
		return $this->belongsTo(\App\Models\Organization::class);
	}

	public function user()
	{
		return $this->belongsTo(\App\User::class, 'user_id');
	}

	public function creator()
	{
		return $this->belongsTo(\App\User::class, 'created_by');
	}

	public function action_logs()
	{
		return $this->hasMany(\App\Models\ActionLog::class, 'id_admin');
	}

	public function beneficiaries()
	{
		return $this->hasMany(\App\Models\Beneficiary::class, 'created_by_id');
	}

	public function campaigns()
	{
		return $this->hasMany(\App\Models\Campaign::class, 'administrator_id');
	}
}
