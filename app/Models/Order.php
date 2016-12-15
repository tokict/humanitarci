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
     * @property int $user_id
     * @property int $campaign_id
     * @property string $status
     * @property string $created_at
     * @property string $updated_at
     * @property int $amount
     * @property string $type
     * @property string $user_ip
     * @property string $order_token
     *
     * @property \App\Models\Donor $donor
     * @property \App\Models\Campaign $campaign
     * @property \App\User $user
     *
     *
     * @package App\Models
     */


    protected $casts = [
        'user_id' => 'int',
        'donor_id' => 'int',
        'campaign_id' => 'int',
        'amount' => 'int',
    ];

    protected $fillable = [
        'user_id',
        'donor_id',
        'campaign_id',
        'updated_at',
        'amount',
        'type',
        'user_ip',
        'status',
        'order_token'
    ];


    public function donor()
    {
        return $this->belongsTo(\App\Models\Donor::class);
    }

    public function campaign()
    {
        return $this->belongsTo(\App\Models\Campaign::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    //Check the status of transaction with the provider
    public function checkTransaction()
    {
        $store_id = (string)env('STORE_ID');
        $order_number = env('ORDER_PREFIX') . $this->getAttribute('id');


        $timestamp = date("YmdHis");
        $client = new Client();

        $res = $client->post(env('PAYMENT_PROVIDER_STATUS_ENDPOINT'), [
            'cert' => [env("PROJECT_DIR").'/Corvus.pem', env('PROVIDER_KEY_PASSWORD')],
            'form_params' => [
                'store_id' => $store_id,
                'order_number' => $order_number,
                'currency_code' => env('CURRENCY_CODE'),
                'timestamp' => $timestamp,
                'hash' => sha1(env('PAYMENT_PROVIDER_KEY') .$order_number . $store_id . '191'.$timestamp)
            ]
        ]);

        $body = $res->getBody();

        $response = simplexml_load_string($body, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($response);
        $array = json_decode($json,TRUE);
        $array['order_id'] = $this->getAttribute('id');

        if(!isset($array['response-code'])){
            return false;
        }

        $renamedFieldsArr = [];
        foreach($array as $key =>  $item){
            if($key == 'cc-type'){
                $key = 'card_type';
            }

            if($key == 'transaction-date-and-time'){
                $key = 'transaction_datetime';
            }
            $renamedFieldsArr[str_replace("-", "_", $key)] = $item;
        }

        $pData = new PaymentProviderDatum($renamedFieldsArr);
        $pData->save();

        return ['status' => $renamedFieldsArr['response_code'], 'payment_provider_data_id' => $pData->id];
    }


}
