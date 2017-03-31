<?php

namespace App\Http\Controllers;

use App\Events\PageViewed;
use App\Http\Requests;
use App\Models\BankTransfersDatum;
use App\Models\Donation;
use App\Models\Donor;
use App\Models\MonetaryOutputSource;
use App\Models\Order;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;


class DonorsController extends Controller
{
    use \App\Traits\ControllerIndexTrait;

    /**
     * Show user listings.
     *
     * @return \Illuminate\Http\Response
     */
    public function listing()
    {
        $param = Input::get('sort');
        if (!Input::get('search')) {
            $order = Input::get('order');
            if ($order) {
                $sort = Input::get('dir');

                $donors = Donor::orderBy($order, $sort)->paginate(20);

            } else {
                $donors = Donor::paginate(20);

            }
        } else {
            $q = Input::get('search');
            $donors = Donor::with('Entity')->with('User')
                ->whereHas('Entity', function ($x) use ($q) {
                    $x->where('name', 'like', '%' . $q . '%');
                })
                ->orWhereHas('User', function ($x) use ($q) {
                    $x->where('username', 'like', '%' . $q . '%');
                })->paginate(20);
        }
        return view('donor.list', ['donors' => $donors, 'param' => $param]);
    }


    /**
     * Show a single donor.
     *
     * @return \Illuminate\Http\Response
     */
    public function view($request, $id)
    {
        $v = \Illuminate\Support\Facades\Validator::make([
            'id' => $id
        ],[
            'id' => 'required'
        ]);
        if ($v->fails())
        {
            abort(404, trans('errors.Donor not found!'));
        }

        $donor = Donor::whereId($id)->first();
        event(new PageViewed(['type' => 'donor', 'id' => $id]));
        return view('donor.view', ['donor' => $donor]);
    }


    /**
     * Show a single donor.
     *
     * @return \Illuminate\Http\Response
     */
    public function login($request)
    {

        if (Request::isMethod('post')) {
            $this->validate($request, [
                'email' => 'required|max:30|email',
                'password' => 'required|max:100',
            ]);

            $input = Input::all();
            $user = User::where('email', $input['email'])->get()->first();
            if ($user) {
                //Login user
                if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']])) {
                    Auth::login($user);
                    if (!empty(session::has('redirectToCart'))) {
                         return redirect('/' . trans('routes.front.donations') . '/' . trans('routes.actions.cart'))->withInput();
                    }
                     return redirect()->intended('/' . Lang::get('routes.front.donors', [],
                            '') . '/' . Lang::get('routes.actions.profile', [], ''))->withInput();

                }else{
                    Session::flash('error', trans("errors.login.We couldn't authorize you using that email and password combination"));

                }
            }

        }
        if (Input::get('fromCart')) {
            session()->put('redirectToCart', true);
        }
        return view('donor.login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect("/");
    }


    public function profile($request, $username)
    {


        if (isset($username)) {
            $user = User::where('username', $username)->get()->first();
            if ($user && $user->donor) {
                $donor = $user->donor;
            } else {
                abort(404, 'Donor sa tim korisničkim imenom ne postoji');
            }
        } else {
            if (isset(Auth::User()->donor)) {
                $donor = Auth::User()->donor;
            } else {
                return redirect('/');
            }
        }


        $donationTransfers = Donation::where('donor_id',
            Auth::User()->donor->id)->whereNotNull('transaction_id')->get();

        $ordersArr = Order::where('donor_id', $donor->id)->where('status', 'pending')->get();
        $orders = [];
        foreach ($ordersArr as $order) {
            //We need to check reference with all possible indexes at the end of reference to see has a certain donation peen paid
            $countOfDonations = count(unserialize($order->donations));

            for($i = 0; $i <= $countOfDonations; $i++){
                $transfer = BankTransfersDatum::where('reference', $order->reference.$i)->get();
                if(!$transfer){
                    $orders[] = $order;
                }
            }

        }

        return view('donor.profile',
            [
                'donor' => $donor,
                'donationTransfers' => $donationTransfers,
                'orders' => $orders

            ]);
    }
}
