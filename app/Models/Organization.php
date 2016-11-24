<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;



/**
 * Class Organization
 * 
 * @property int $id
 * @property int $legal_entity_id
 * @property int $name
 * @property int $contact_email
 * @property int $contact_phone
 * @property int $donations_address
 * @property int $donations_coordinates
 * @property int $description
 * @property int $logo_id
 * @property int $represented_by
 * @property int $city_id
 * @property int $status
 *
 * @property \App\Models\Person $person
 * @property \App\Models\LegalEntity $legalEntity
 * @property \App\Models\City $city
 * @property \App\Models\Media $logo
 *
 * @property \Illuminate\Database\Eloquent\Collection $users
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
class Organization extends BaseModel
{
	public $timestamps = false;

	protected $casts = [
		'legal_entity_id' => 'int',
        'logo_id' => 'int',
        'city_id' => 'int',
        'represented_by' => 'int'
	];

	protected $fillable = [
		'legal_entity_id',
		'name',
		'contact_email',
		'contact_phone',
		'donations_address',
		'donations_coordinates',
		'description',
		'logo_id',
		'represented_by',
		'city_id',
		'status',
	];

	public function legalEntity()
	{
		return $this->belongsTo(\App\Models\LegalEntity::class);
	}

    public function city()
    {
        return $this->belongsTo(\App\Models\City::class);
    }

    public function person()
    {
        return $this->belongsTo(\App\Models\Person::class, 'represented_by');
    }

    public function logo()
    {
        return $this->belongsTo(\App\Models\Media::class);
    }


	public function users()
	{
		return $this->hasMany(\App\User::class);
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
		return $this->hasMany(\App\Models\OutgoingSms::class);
	}


	/**
	 * Check if beneficiary has a campaign with status 'active'
	 * @return int
	 */
	public function hasActiveCampaign()
	{
		return count(Campaign::where([['organization_id', $this->getAttribute('id')], ['status', 'active']])->get());
	}

	/**
	 * Get all campaigns with status 'reached', 'failed'
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function getSuccessfulCampaigns()
	{
		return Campaign::where('organization_id', $this->getAttribute('id'))->whereIn('status', ['reached', 'failed'])->get();
	}

	/**
	 * Get all donors that donated to this beneficiary
	 * @return array
	 */
	public function getDonors()
	{
		$campaigns = Campaign::where('organization_id', $this->getAttribute('id'))->get();
		$donors = [];
		foreach ($campaigns as $c) {
			foreach ($c->donations as $d) {
				if(!$d->donor->anonymous) {
					$donors[] = $d->donor;
				}
			}
		};

		return $donors;

	}

	/**
	 * Get average donation amount for beneficiary
	 * @return int
	 */
	public function getAverageDonation()
	{
		$campaigns = Campaign::where('organization_id', $this->getAttribute('id'))->get();
		$totalAmount = 0;

		foreach ($campaigns as $c) {
			foreach ($c->donations as $d)
				$totalAmount += $d->amount;
		}
		return $totalAmount;

	}
}
