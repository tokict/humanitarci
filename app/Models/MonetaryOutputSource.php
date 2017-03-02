<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;


/**
 * Class MonetaryOutputSource
 * Monetary output handles all cash coming out the platform.
 *
 * @property int $id
 * @property int $monetary_output_id
 * @property int $amount
 * @property int $donation_id
 * @property \Carbon\Carbon $created_at
 *
 *
 *
 * @property \App\Models\MonetaryOutput $monetary_output
 * @property \App\Models\Donation $donation
 *
 *
 * @package App\Models
 */
class MonetaryOutputSource extends BaseModel
{
    public $timestamps = false;
    protected $table = 'monetary_output_sources';
    protected $casts = [
        'monetary_output_id' => 'int',
        'amount' => 'int',
        'donation_id' => 'int',
    ];

    protected $fillable = [
        'monetary_output_id',
        'amount',
        'donation_id'
    ];

    public function monetary_output()
    {
        return $this->belongsTo(\App\Models\MonetaryOutput::class);
    }


    public function donation()
    {
        return $this->belongsTo(\App\Models\Donation::class);
    }

}
