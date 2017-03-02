<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Donation;
use App\Models\Donor;
use App\Models\MonetaryOutputSource;
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
        $donors = Donor::paginate(30);
        return view('donor.list', ['donors' => $donors]);
    }






    /**
     * Show a single donor.
     *
     * @return \Illuminate\Http\Response
     */
    public function login($request, $id)
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
                    if(!empty(session::has('redirectToCart'))){
                        return redirect('/'.trans('routes.front.donations').'/'.trans('routes.actions.cart'))->withInput();
                    }
                    return redirect()->intended('/' . Lang::get('routes.front.donors', [], '') . '/' . Lang::get('routes.actions.profile', [], ''))->withInput();

                }
            }

        }
            if(Input::get('fromCart')){
                session()->put('redirectToCart', true);
            }
        return view('donor.login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect("/");
    }


    public function profile($request,$username)
    {
        if($username){
            $user = User::where('username', $username)->get()->first();
            if($user && $user->donor) {
                $donor = $user->donor;
                }
        }else{
            if(isset(Auth::User()->donor)) {
                $donor = Donor::find(Auth::User()->donor->id);
            }else{
                return redirect('/');
            }
        }

        $distributedFunds = MonetaryOutputSource::with('Donation')->whereHas('Donation', function($q) use ($donor){
            $q->where('donor_id', $donor->id);
        })->get();

        $donationTransfers= Donation::where('donor_id', Auth::User()->donor->id)->whereNotNull('transaction_id')->get();

        return view('donor.profile', ['donor' => $donor, 'distributedFunds' => $distributedFunds, 'donationTransfers' => $donationTransfers]);
    }
}
