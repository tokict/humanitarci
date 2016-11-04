<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Organization
 * 
 * @property int $id
 * @property int $legal_entity_id
 * 
 * @property \App\Models\LegalEntity $legal_entity
 * @property \Illuminate\Database\Eloquent\Collection $admins
 * @property \Illuminate\Database\Eloquent\Collection $campaigns
 * @property \Illuminate\Database\Eloquent\Collection $documents
 * @property \Illuminate\Database\Eloquent\Collection $donations
 * @property \Illuminate\Database\Eloquent\Collection $goods_inputs
 * @property \Illuminate\Database\Eloquent\Collection $media_links
 * @property \Illuminate\Database\Eloquent\Collection $organization_reports
 * @property \Illuminate\Database\Eloquent\Collection $outgoing_mails
 * @property \Illuminate\Database\Eloquent\Collection $outgoing_pushes
 * @property \Illuminate\Database\Eloquent\Collection $outgoing_sms
 *
 * @package App\Models
 */
class Organization extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'legal_entity_id' => 'int'
	];

	protected $fillable = [
		'legal_entity_id'
	];

	public function legal_entity()
	{
		return $this->belongsTo(\App\Models\LegalEntity::class);
	}

	public function admins()
	{
		return $this->hasMany(\App\Models\Admin::class);
	}

	public function campaigns()
	{
		return $this->hasMany(\App\Models\Campaign::class);
	}

	public function documents()
	{
		return $this->hasMany(\App\Models\Document::class);
	}

	public function donations()
	{
		return $this->hasMany(\App\Models\Donation::class);
	}

	public function goods_inputs()
	{
		return $this->hasMany(\App\Models\GoodsInput::class);
	}

	public function media_links()
	{
		return $this->hasMany(\App\Models\MediaLink::class);
	}

	public function organization_reports()
	{
		return $this->hasMany(\App\Models\OrganizationReport::class);
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
