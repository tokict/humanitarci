<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Order;
use App\Models\Person;
use App\Models\Setting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;


class DonationsController extends Controller
{
    use \App\Traits\ControllerIndexTrait;

    /**
     * Show donation listings.
     *
     * @return \Illuminate\Http\Response
     */
    public function listing()
    {
        $donations = Donation::paginate(30);
        return view('donation.list', ['donations' => $donations]);
    }


    /**
     * Create a single donation.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($request)
    {
        $campaignId = (int)Input::get('campaign');
        $type = Input::get('type');
        $amount = (int)Input::get('amount');

        $campaign = Campaign::find($campaignId);

        if ($campaign) {

            //Add the donation to cart
            $donations = session('donations');
            $exists = false;
            if (!empty($donations)) {
                foreach ($donations as &$d) {
                    //Exists, Add the amount to existing donation
                    if ($d['campaign'] == $campaignId && $d['type'] == $type) {
                        $d['amount'] = $d['amount'] += $amount;
                        $exists = true;

                    }
                }
            }
            //New donation
            if (!$exists) {
                session()->push('donations', ['campaign' => $campaign->id, 'type' => $type, 'amount' => $amount]);
            } else {
                session()->put('donations', $donations);
            }

            return redirect("/" . trans('routes.front.donations') . "/" . trans('routes.actions.cart'));

        }
    }

    /**
     * Show cart.
     *
     * @return \Illuminate\Http\Response
     */
    public function cart()
    {


        $cart = !empty(Session::get('donations')) ? Session::get('donations') : [];
        $recurring = false;
        $status = !empty(Input::get('status')) ? Input::get('status') : null;

        if ($cart) {
            $order = $this->process();
        } else {
            $order = null;
        }

        if(count($cart) && !isset($cart[0]['order_id'])) {
            foreach ($cart as &$item) {
                $item['order_id'] = $order->order_id;
            }
            Session::set('donations', $cart);
        }


        if ($order) {
            $orderId = explode("_", $order->order_number);
            $orderId = $orderId[count($orderId) - 1];
            $ordModel = Order::find($orderId);
        }else{
            $ordModel = null;
        }


        $provider_tax = (!isset($ordModel) || $ordModel->payment_method == 'bank_transfer') ? 0 : Setting::getSetting('payment_provider_tax')->value;
        $platform_tax = Setting::getSetting('payment_platform_tax')->value;
        $bank_tax = (!isset($ordModel) || $ordModel->payment_method == 'bank_transfer') ? 0 : Setting::getSetting('payment_bank_tax')->value;
        $total = 0;
        $totalTaxes = $bank_tax + $platform_tax + $provider_tax;


        //Setup cart display data
        foreach ($cart as &$item) {
            $cid = isset($item['campaign']->id)?$item['campaign']->id:$item['campaign'];
            $item['campaign'] = Campaign::where('id', $cid)->get()->first();
            if ($item['type'] == 'monthly') {
                $recurring = true;
            }
            $total += $item['amount'];
        }


        //This means user is back from payment
        if ($status) {
            //Return success with unsetting paid donation (all single or first monthly)
            if ($status == 'success') {
                Artisan::call('CheckPayments', ['--single' => true]);

                $donations = Session::get('donations');
                //Unset all paid donations from session
                if ($donations) {
                    foreach ($donations as $key => $item) {
                        if ($item['type'] == 'single') {

                            unset($donations[$key]);
                        }
                    }
                    foreach ($donations as $key => $item) {
                        if ($item['type'] == 'monthly') {

                            unset($donations[$key]);
                            break;
                        }
                    }
                }
                Session::set('donations', $donations);

                return redirect("/" . trans('routes.front.donations') . "/" . trans('routes.actions.cart'))
                    ->with('success', trans('strings.payment.Payment was successful! Your donation should be visible in no later than 24 hours after payment'));
            }

            //Return fail
            if ($status == 'fail') {
                return redirect("/" . trans('routes.front.donations') . "/" . trans('routes.actions.cart'))
                    ->withErrors(trans('strings.payment.Payment failed! We are sorry, but your donation was not completed'));
            }
        }


        return view('donation.cart', [
            'donations' => $cart,
            'total' => $total,
            'taxes' => ['bank_tax' => $bank_tax, 'credit_card_processor_tax' => $provider_tax, 'platform_tax' => $platform_tax],
            'total_tax' => $totalTaxes,
            'recurring' => $recurring,
            'order' => $order,
            'orderModel' => $ordModel
        ]);

    }

    /**
     * Process the cart and send user to payment
     *
     */
    public function process()
    {

        //User is logged in


        //Do donation processing
        //Process single in one payment, recurring when singles are done
        if (!empty(Session::get('donations'))) {
            $orderSingle = new \App\Entities\Order(Session::get('donations'));
            if ($orderSingle) {

                return $orderSingle;

            } else {
                //Process next monthly donation
                $orderMonthly = new \App\Entities\Order(Session::get('donations'));
                if ($orderMonthly) {
                    return $orderMonthly;
                }
            }
        }
    }

    /**
     * Remove item from session with passed index
     *
     */
    public function remove($request, $index)
    {

        $donations = Session::get('donations');
        unset($donations[$index]);
        Session::set('donations', $donations);

        return redirect()->back()->with('success', [trans('Item removed')]);
    }


    public function bank($request, $orderNr)
    {
        $order = Order::find($orderNr);
        $cart = !empty(session('donations')) ? session('donations') : [];
        //Setup cart display data
        foreach ($cart as &$item) {
            $cid = isset($item['campaign']->id)?$item['campaign']->id:$item['campaign'];
            $item['campaign'] = Campaign::where('id', $cid)->get()->first();

        }
        if ($order) {
            $order->update(['payment_method' => 'bank_transfer']);
            $order->save();
        } else {
            abort(404);

        }

        return view('donation.bank', [
            'order' => $order,
            'donations' => $cart
        ]);
    }

}
