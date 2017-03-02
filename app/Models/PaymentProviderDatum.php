<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;


/**
 * Class PaymentProviderDatum
 * Data related to payment providers and payments. Callback data etc
 *
 *
 * @property int $id
 * @property int $order_id
 * @property string $order_number
 * @property int $transaction_amount
 * @property string  $transaction_datetime
 * @property string $status
 * @property string $response_message
 * @property string $response_code
 * @property string $currency_code
 * @property string $card_type
 * @property string $cardholder_name
 * @property string $cardholder_surname
 * @property string $cardholder_address
 * @property string $cardholder_city
 * @property string $cardholder_zip_code
 * @property string $cardholder_email
 * @property string $cardholder_phone
 * @property string $cardholder_country
 * @property string $card_details
 * @property string $reference_number
 * @property string $approval_code
 * $@property \App\Models\Order $order;
 *
 * @package App\Models
 */
class PaymentProviderDatum extends BaseModel
{
    public $timestamps = false;

    protected $casts = [
        'order_id' => 'int'
    ];


    protected $fillable = [
        'order_id',
        'order_number',
        'transaction_amount',
        'transaction_datetime',
        'response_message',
        'response_code',
        'currency_code',
        'status',
        'card_type',
        'cardholder_name',
        'cardholder_surname',
        'cardholder_address',
        'cardholder_city',
        'cardholder_zip_code',
        'cardholder_email',
        'cardholder_phone',
        'cardholder_country',
        'card_details',
        'reference_number',
        'approval_code',
    ];


    public function order()
    {
        return $this->belongsTo(\App\Models\Order::class);
    }
}
