<?php

namespace App\Models;

use GuzzleHttp\Client;

class Order extends BaseModel
{
    /**
     * Class Organization
     *
     * @property int $id
     * @property int $donor_id
     * @property int $campaign_id
     * @property string $status
     * @property string $created_at
     * @property string $updated_at
     * @property int $amount
     * @property string $type
     * @property string $user_ip
     *
     * @property \App\Models\Donor $donor
     * @property \App\Models\Campaign $campaign
     *
     *
     * @package App\Models
     */


    protected $casts = [
        'donor_id' => 'int',
        'campaign_id' => 'int',
        'amount' => 'int',
    ];

    protected $fillable = [
        'donor_id',
        'campaign_id',
        'updated_at',
        'amount',
        'type',
        'user_ip',
        'status',
    ];


    public function donor()
    {
        return $this->belongsTo(\App\Models\Donor::class);
    }

    public function campaign()
    {
        return $this->belongsTo(\App\Models\Campaign::class);
    }

    //Check the status of transaction with the provider
    public function checkTransaction()
    {
        $store_id = env('STORE_ID');
        $order_number = 'don_nr_' . $this->getAttribute('id');
        $hash = $this->getAttribute('hash');

        /*$client = new Client();
        $res = $client->post(env('PAYMENT_PROVIDER_STATUS_ENDPOINT'), [
            'cert' => ['CorvusCPS_test.key.pem', env('PROVIDER_KEY_PASSWORD')],
            'store_id' => $store_id,
            'order_number' => $order_number,
            'currency_code' => strtoupper(env('CURRENCY')),
            'timestamp' => date("yyyyMMddHHmmss"),
            'hash' => $hash
        ]);

        $xml = $res->getBody();
        return $xml;*/
        $data = [
            'order_number' => $order_number,
            'order_id' => $this->getAttribute('id'),
            'transaction_amount' => $this->getAttribute('amount'),
            'transaction_datetime' => $this->getAttribute('created_at'),
            'status' => '0',
            'response_message' => "Success",
            'response_code' => '0',
            'currency_code' => "hrk",
            'card_type' => "visa",
            'cardholder_name' => "Tino",
            'cardholder_surname' => "Tokic",
            'cardholder_address' => "Address sfa",
            'cardholder_city' => "Solin",
            'cardholder_zip code' => "21210",
            'cardholder_email' => "tino@tokic.com.hr    ",
            'cardholder_phone' => "0877190412",
            'cardholder_country' => "Bulgaria",
            'card_details' => "hhstdrth",
            'rrn' => "65465",
            'approval_code' => "0"
        ];


        $pData = new PaymentProviderDatum($data);
        $pData->save();

        return ['status' => 'done', 'payment_provider_data_id' => $pData->id];
    }


}
