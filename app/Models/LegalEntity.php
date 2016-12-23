<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;


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
 *
 * @property string $organization_id
 *
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
 * @property bool $beneficiary_id
 * Is the organization a beneficiary
 *
 * @property int $created_by
 *
 *  * @property bool $donor_id
 * Is the organization a donor
 *
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $modified_at
 *
 * @property \Illuminate\Database\Eloquent\Collection $beneficiaries
 * @property \App\Models\GroupLegalEntity $group_legal_entity
 * @property \App\Models\City $city
 * @property \App\Models\Donor $donor
 * @property \App\Models\Admin $creator
 * @property \App\Models\Beneficiary $beneficiary
 * @property \App\Models\Person $person
 * @property \App\Models\Organization $organization
 * @property \App\Models\Bank $bank
 * @property \Illuminate\Database\Eloquent\Collection $groups
 * @property \Illuminate\Database\Eloquent\Collection $organizations
 * @property \Illuminate\Database\Eloquent\Collection $outgoing_mails
 * @property \Illuminate\Database\Eloquent\Collection $outgoing_pushes
 * @property \Illuminate\Database\Eloquent\Collection $outgoing_sms
 *
 * @package App\Models
 */
class LegalEntity extends BaseModel
{
    public $timestamps = false;

    protected $casts = [
        'is_beneficiary' => 'bool',
        'created_by' => 'int'
    ];

    protected $dates = [
        'modified_at'
    ];

    protected $fillable = [
        'name',
        'tax_id',
        'city_id',
        'address',
        'bank_id',
        'bank_acc',
        'beneficiary_id',
        'donor_id',
        'contact_phone',
        'contact_email',
        'represented_by',
        'modified_at',
        'created_by'
    ];


    public function group_legal_entity()
    {
        return $this->belongsTo(\App\Models\GroupLegalEntity::class);
    }

    public function city()
    {
        return $this->belongsTo(\App\Models\City::class);
    }

    public function donor()
    {
        return $this->belongsTo(\App\Models\Donor::class);
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\Admin::class);
    }

    public function beneficiary()
    {
        return $this->belongsTo(\App\Models\Beneficiary::class);
    }


    public function person()
    {
        return $this->belongsTo(\App\Models\Person::class, 'represented_by');
    }

    public function bank()
    {
        return $this->belongsTo(\App\Models\Bank::class);
    }

    public function organization()
    {
        return $this->belongsTo(\App\Models\Organization::class);
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
        return $this->hasMany(\App\Models\OutgoingSms::class);
    }
}
