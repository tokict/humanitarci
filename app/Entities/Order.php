<?php
/**
 * Created by PhpStorm.
 * User: tino
 * Date: 12/1/16
 * Time: 1:33 PM
 */

namespace App\Entities;


use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Order
{
    /**
     * @property string $cart
     * Shopping-cart contents description
     */
    public $cart;

    /**
     * @property string $target
     * For redirect form
     */

    public $target;
    /**
     * @property string $mode
     * For redirect form
     */

    public $mode;
    /**
     * @property string $store_id
     * Our store id with provider
     */

    public $store_id;
    /**
     * @property integer $order_number
     * Internal unique order number. Must be AI
     */
    public $order_number;

    /**
     * @property string $language
     * Language to be used on the PP site
     */
    public $language;

    /**
     * @property string $currency
     * In what currency will it be charged. Selecting wrong currency can lead to undesired
     * consequences as some PP's wont exchange it if they don't support it
     */
    public $currency;

    /**
     * @property float $amount
     * Total amount of the order
     */
    public $amount;

    /**
     * @property string $hash
     * Security hash
     */
    public $hash;

    /**
     * @property string $require_complete
     * False = sale, true = preauth
     */
    public $require_complete;

    /**
     * @property string $donations
     * Serialized data from session => donations
     */
    public $donations;


    /**
     * @property string $payment_endpoint
     * SWhere do we redirect users for payment
     */
    public $payment_endpoint;

    protected $key;

    protected $provider_id;


    /**
     * Donations can be only single or monthly. They cannot mix! First we process single in one order
     * and then what is left of monthly one by one
     */
    public function __construct($donations)
    {


        $this->payment_endpoint = env('PAYMENT_ENDPOINT');
        $this->currency = strtoupper(env("CURRENCY"));
        $this->store_id = (string)env("STORE_ID");
        $this->language = env("LANGUAGE");
        $this->target = '_top';
        $this->mode = 'form';
        $this->require_complete = "false";
        $this->key = env('PAYMENT_PROVIDER_KEY');


        $single = [];
        $monthly = [];
        foreach ($donations as $donation) {
            if ($donation['type'] == 'single') {
                $single[] = $donation;
            } else {
                $monthly[] = $donation;
            }
        }
        if (count($single)) {
            $this->donations = $single;
            //if the donation has order_id it means it was saved before and this is page reload
            if (isset($single[0]['order_id'])) {
                $order = \App\Models\Order::find($single[0]['order_id']);
                if ($order) {
                    $this->order_number = $order->id;
                    $this->amount = $order->amount;
                    $this->hash = sha1($this->key . ':' . env('ORDER_PREFIX').$this->order_number . ':' . $this->amount . ':' . $this->currency);
                    $this->type = $order->type;
                    $this->cart = $order->cart;
                    $this->user_ip = \Illuminate\Support\Facades\Request::ip();
                    $this->updated_at = date("Y-m-d H:i:s");
                }
            }

            //Process single donations in one order
            $amount = 0;
            foreach ($single as $key => $item) {
                $campaign = Campaign::where('id', $item['campaign'])->get()->first();
                $amount += $item['amount'];
                $this->cart .= '|' . $campaign->name . ' - ' . $item['amount'] . env('CURRENCY');

            }
            $this->amount =$amount;


        } else {
            //There are no single ones, process first monthly
            $this->donations = $monthly;
            if (isset($monthly[0]['order_id'])) {
                $order = \App\Models\Order::find($monthly[0]['order_id']);
                if ($order) {
                    $this->order_number = $order->id;
                    $this->amount = $order->amount;
                    $this->hash = sha1($this->key . ':' . env('ORDER_PREFIX').$this->order_number . ':' . $this->amount . ':' . $this->currency);
                    $this->type = $order->type;
                    $this->cart = $order->cart;
                    $this->user_ip = \Illuminate\Support\Facades\Request::ip();
                    $this->updated_at = date("Y-m-d H:i:s");
                }
            }
        }
        $this->amount = number_format($this->amount, 2, '.', "");

    }

    /**
     * @return integer
     * Saves order to DB
     */
    public function save()
    {
        $order = new \App\Models\Order;
        $order->donor_id = Auth::User()->donor->id;
        $order->donations = serialize($this->donations);
        $order->status = 'pending';
        $order->amount = $this->amount;
        $order->type = 'single';
        $order->user_ip = \Request::ip();
        $order->save();

        $this->order_number = $order->id;
        $this->hash = sha1($this->key . ':' . env('ORDER_PREFIX').$this->order_number . ':' . $this->amount . ':' . $this->currency);
        $order->hash = $this->hash;
        $order->save();

        return $this->order_number;
    }


}