<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Donor;
use App\Models\Order;
use App\User;
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
            if ($campaign->current_funds + $amount > $campaign->target_amount) {
                return Redirect::back()->withErrors(['msg', 'Your donation is higher than needed for the campaign. Please check your amount']);
            } else {
                //Add the donation to cart

                $exists = false;
                if (!empty(session('donations'))) {
                    foreach (session('donations') as $d) {
                        //Exists, Add the amount to existing donation
                        if ($d['campaign'] == $campaignId && $d['type'] == $type) {
                            $d['amount'] += $amount;
                            $exists = true;
                        }
                    }
                }
                //New donation
                if (!$exists) {
                    session()->push('donations', ['campaign' => $campaign->id, 'type' => $type, 'amount' => $amount]);
                }

                return redirect("/" . trans('routes.front.donations') . "/" . trans('routes.actions.cart'));
            }
        }
    }

    /**
     * Show cart.
     *
     * @return \Illuminate\Http\Response
     */
    public function cart($request, $id)
    {

        $total = 0;
        $taxes = 0;
        $totalWithTaxes = 0;
        $cart = !empty(session('donations')) ? session('donations') : [];
        $recurring = false;
        $redirectedFromPaymentOrder = Input::get('order');
        $redirectedFromPaymentWithSuccess = Input::has('success');
        $redirectedFromPaymentWithFail = Input::has('fail');

        foreach ($cart as &$item) {
            $item['campaign'] = Campaign::where('id', $item['campaign'])->get()->first();
            if ($item['type'] == 'monthly') {
                $recurring = true;
            }
            $total += $item['amount'];
            $tax = 0;
            $taxes += $tax;
            $totalWithTaxes += $item['amount'] + $tax;
        }

        if ($cart) {
            $order = $this->process();

            return view('donation.cart', [
                'donations' => $cart,
                'total' => $total,
                'taxes' => $taxes,
                'totalWithTaxes' => $totalWithTaxes,
                'recurring' => $recurring,
                'order' => $order
            ]);
        } else {
            //Return success
            if ($redirectedFromPaymentWithSuccess) {
                $donations = Session::get('donations');
                //Unset all paid donations from session
                foreach ($donations as $key => $item) {
                    if ($item['order_id'] == $redirectedFromPaymentOrder) {

                        unset($donations[$key]);

                    }
                }
                Session::set('donations', $donations);

                return redirect("/" . trans('routes.front.donors') . "/" . trans('routes.actions.profile'))
                    ->with('success', trans('strings.payment.Payment was successful! Your donation should be visible in no later than 24 hours after payment'));
            }

            //Return fail
            if ($redirectedFromPaymentWithFail) {
                return redirect("/" . trans('routes.front.donors') . "/" . trans('routes.actions.profile'))
                    ->with('error', trans('strings.payment.Payment failed! We are sorry, but your donation was refused by the payment provider'));
            }
        }
    }

    /**
     * Process tha cart and send user to payment
     *
     */
    public function process()
    {
        //Saved data if user was redirected to login
        if (session('cartInput')) {
            $input = session('cartInput');
            session()->forget('cartInput');
        } else {
            $input = Input::all();
        }

        //See if user has account. If not, send to registration
        if (!Auth::check()) {
            session()->put('redirectAfterLogin', "/" . trans('routes.front.donations') . "/" . trans('routes.actions.process'));
            session()->put('cartInput', Input::all());
            return redirect("/" . trans('routes.front.donors') . "/" . trans('routes.actions.login'))->withInput();
            die;
        }

        //User is logged in


        //Do donation processing
        //Process single in one payment
        $orderSingle = new \App\Entities\Order(Session::get('donations'));
        if (!$orderSingle->order_number) {
            if ($orderSingle) {
                $donations = Session::get('donations');
                foreach ($donations as &$donation) {
                    if ($donation['type'] == 'single') {

                        $donation['order_id'] = $orderSingle->save();

                    }
                }
                Session::set('donations', $donations);
            }
            return $orderSingle;

        } else {
            //Process next monthly donation
            $orderMonthly = new \App\Entities\Order(Session::get('donations'));
            if ($orderMonthly) {
                $donations = Session::get('donations');
                foreach ($donations as &$donation) {
                    if ($donation == 'monthly') {
                        $donation['order_id'] = $orderMonthly->order_number;
                        //Break because we do one at a time
                        break;
                    }


                }
                Session::set('donations', $donations);
                return $orderMonthly;
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
}
