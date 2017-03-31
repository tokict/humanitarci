<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Collection;


/**
 * Class MonetaryOutput
 * Monetary output handles all cash coming out the platform.
 *
 * @property int $id
 * @property int $campaign_id
 * @property int $amount
 * @property string $description
 * @property int $receiving_entity_id
 * @property int $receiving_person_id
 * @property int $beneficiary_payment
 * @property string $receipt_ids
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $action_time
 * @property int $created_by_id
 * @property int $expenses_payment
 *
 *
 *
 * @property \App\Models\Campaign $campaign
 * @property \App\Models\LegalEntity $receiving_entity
 * @property \App\Models\Person $receiving_person
 * @property \App\User $admin
 *
 * @package App\Models
 */
class MonetaryOutput extends BaseModel
{
    public $timestamps = false;
    protected $table = 'monetary_output';
    protected $casts = [
        'campaign_id' => 'int',
        'amount' => 'int',
        'receiving_entity_id' => 'int',
        'receiving_person_id' => 'int',
        'beneficiary_payment' => 'int',
        'created_by_id' => 'int',
        'expenses_payment' => 'int'
    ];

    protected $fillable = [
        'campaign_id',
        'amount',
        'description',
        'receiving_entity_id',
        'receiving_person_id',
        'beneficiary_payment',
        'receipt_ids',
        'action_time',
        'created_by_id',
        'expenses_payment',
    ];

    public function campaign()
    {
        return $this->belongsTo(\App\Models\Campaign::class);
    }


    public function receiving_entity()
    {
        return $this->belongsTo(\App\Models\LegalEntity::class, 'receiving_entity_id');
    }

    public function receiving_person()
    {
        return $this->belongsTo(\App\Models\Person::class, 'receiving_person_id');
    }

    public function admin()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'created_by_id');
    }

    /**
     * @return Collection
     */
    public function getReceipts()
    {
        $res =  Media::whereIn('id', explode(",", $this->getAttribute('receipt_ids')))->get();
        return $res;

    }
}
