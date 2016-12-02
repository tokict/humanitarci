<?php

namespace App\Models;

use GuzzleHttp\Client;

class Order extends BaseModel
{
    /**
     * Class Organization
     *
     * @property int $id
     * @property int $user_id
     * @property int $campaign_id
     * @property string $status
     * @property string $created_at
     * @property string $updated_at
     * @property int $amount
     * @property string $type
     * @property string $user_ip
     *
     * @property \App\User $user
     * @property \App\Models\Campaign $campaign
     *
     *
     * @package App\Models
     */


    protected $casts = [
        'user_id' => 'int',
        'campaign_id' => 'int',
        'amount' => 'int',
    ];

    protected $fillable = [
        'user_id',
        'campaign_id',
        'updated_at',
        'amount',
        'type',
        'user_ip',
        'status',
    ];



    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function campaign()
    {
        return $this->belongsTo(\App\Models\Campaign::class);
    }

    //Check the status of transaction with the provider
    public function checkTransaction()
    {
        $store_id = env('STORE_ID');
        $order_number = 'don_nr_.'.$this->getAttribute('id');
        $hash = $this->getAttribute('hash');


        $client = new Client();
        $res = $client->post(env('PAYMENT_PROVIDER_STATUS_ENDPOINT'), [
            'cert' => ['CorvusCPS_test.key.pem', env('PROVIDER_KEY_PASSWORD')],
            'store_id' => $store_id,
            'order_number' => $order_number,
            'currency_code' => strtoupper(env('CURRENCY')),
            'timestamp' => date("yyyyMMddHHmmss"),
            'hash' => $hash
        ]);

        $xml = $res->getBody();
        return $xml;
    }

}
