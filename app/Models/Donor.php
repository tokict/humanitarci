<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;



/**
 * Class Donor
 * Donor is any person or legal_entity that is registered as a donor on the site
 * 
 * @property int $id
 * @property int $person_id
 * Id of the person that is the real donor
 *
 * @property int $entity_id
 * Id of the legal_entity if the donor is organization
 *
 * @property string $amount_donated
 * Total amount this donor has donated
 *
 * @property int $user_id
 * Who is the user benind this donor
 *
 * @property string $total_donations
 * Total number of donations by this donor
 *
 * @property string $goods_donated
 * List of goods and amounts donated by this donor in total -serialized array
 *
 * @property string $services_donated
 * List of services donated by this donor = serialized array
 *
 * @property int $anonymous
 * Is the donor anonymous
 *
 * @property \App\Models\Person $person
 * @property \App\User $user
 *
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $modified_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $action_logs
 * @property \Illuminate\Database\Eloquent\Collection $documents
 * @property \Illuminate\Database\Eloquent\Collection $donations
 * @property \Illuminate\Database\Eloquent\Collection $donor_reports
 * @property \Illuminate\Database\Eloquent\Collection $goods_inputs
 * @property \Illuminate\Database\Eloquent\Collection $media_links
 * @property \Illuminate\Database\Eloquent\Collection $monetary_inputs
 * @property \Illuminate\Database\Eloquent\Collection $outgoing_mails
 * @property \Illuminate\Database\Eloquent\Collection $outgoing_pushes
 * @property \Illuminate\Database\Eloquent\Collection $outgoing_sms
 * @property \Illuminate\Database\Eloquent\Collection $subscriptions
 *
 * @package App\Models
 */
class Donor extends BaseModel
{
	public $timestamps = false;

	protected $casts = [
		'person_id' => 'int',
		'entity_id' => 'int'
	];

	protected $dates = [
		'modified_at'
	];

	protected $fillable = [
		'person_id',
		'entity_id',
		'user_id',
		'amount_donated',
		'total_donations',
		'goods_donated',
		'services_donated',
		'modified_at'
	];

	public function action_logs()
	{
		return $this->hasMany(\App\Models\ActionLog::class);
	}

	public function documents()
	{
		return $this->hasMany(\App\Models\Document::class);
	}

	public function donations()
	{
		return $this->hasMany(\App\Models\Donation::class);
	}

	public function person()
	{
		return $this->belongsTo(\App\Models\Person::class);
	}

	public function user()
	{
		return $this->belongsTo(\App\User::class);
	}

	public function donor_reports()
	{
		return $this->hasMany(\App\Models\DonorReport::class);
	}

	public function goods_inputs()
	{
		return $this->hasMany(\App\Models\GoodsInput::class);
	}

	public function media_links()
	{
		return $this->hasMany(\App\Models\MediaLink::class);
	}

	public function monetary_inputs()
	{
		return $this->hasMany(\App\Models\MonetaryInput::class);
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

	public function subscriptions()
	{
		return $this->hasMany(\App\Models\Subscription::class);
	}

	public function getCampaigns()
	{
		$campaigns = Campaign::with('Donations')->whereHas('Donations', function($q){
			$q->where('donor_id', $this->getAttribute('id'));
		})->get();

		return $campaigns;

	}
}
