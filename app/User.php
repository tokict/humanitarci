<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * @property int $id
     * @property string $name
     * @property string $email
     * @property string $password
     * @property string $remember_token
     * @property string $username
     * @property int $created_by
     * @property int $organization_id
     * @property int $donor_id
     * @property int $person_id
     * @property int $admin
     * @property int $super_admin
     * @property \Carbon\Carbon $created_at
     * @property \Carbon\Carbon $modified_at
     *
     * @property \App\Models\Person $person
     * Who is this
     * @property \App\Models\Organization $organization
     *
     * @property \App\User $creator
     *
     * @property \Illuminate\Database\Eloquent\Collection $users
     *
     *
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    public $timestamps = false;

    protected $casts = [
        'id' => 'int',
        'created_by' => 'int',
        'organization_id' => 'int',
        'person_id'=> 'int',
        'donor_id' => 'int'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'remember_token',
        'created_by',
        'organization_id',
        'person_id',
        'donor_id'
    ];


    public function users()
    {
        return $this->hasMany(\App\User::class);
    }

    public function person()
    {
        return $this->belongsTo(\App\Models\Person::class);
    }

    public function creator()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function organization()
    {
        return $this->belongsTo(\App\Models\Organization::class);
    }


    public function donor()
    {
        return $this->hasOne(\App\Models\Donor::class);
    }
}
