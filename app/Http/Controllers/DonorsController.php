<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Donor;
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
     * Show a single user.
     *
     * @return \Illuminate\Http\Response
     */
    public function view($request, $id)
    {

        $campaign = Donor::whereId($id)->first();
        return view('donor.view', ['donor' => $campaign]);
    }


    /**
     * Register new donor
     *
     * @return \Illuminate\Http\Response
     */
    public function registration($request, $id)
    {
        if (Request::isMethod('post')) {
            $this->validate($request, [
                'email' => 'required|max:30|email',
                'username' => 'unique:users|max:100',
                'password' => 'required|max:100|same:re-password',
                're-password' => 'required|max:100',


            ]);
            $input = Input::all();
            $user = User::where('email', $input['email'])->get()->first();
            if ($user) {
                //Create donor only
                if(!$user->donor) {
                    $donor = new Donor;
                    $donor->user_id = $user->id;
                    $donor->save();
                    if(isset($input['username'])){
                        $user->username =  $input['username'];
                        $user->save();
                    }
                }
            } else {
                //Create user and donor
                $uData = [
                    'username' => $input['username'],
                    'email' => $input['email'],
                    'password' => bcrypt($input['password'])
                ];


                $user = User::create($uData);
                if ($user) {
                    //Login user
                    Auth::attempt(['email' => $input['email'], 'password' => $input['password']]);
                }
                $donor = Donor::create(['user_id' => $user->id]);
            }

            if ($donor) {
                return redirect('/' . Lang::get('routes.front.donors', [], '') . '/' . Lang::get('routes.actions.profile', [], ''));
            }
        }

        $donor = Donor::whereId($id)->first();
        return view('donor.register', ['donor' => $donor]);
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
                    if(!empty(session('redirectAfterLogin'))){
                        return redirect(session('redirectAfterLogin'))->withInput();
                    }
                    return redirect()->intended('/' . Lang::get('routes.front.donors', [], '') . '/' . Lang::get('routes.actions.profile', [], ''))->withInput();

                }
            }

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


        return view('donor.profile', ['donor' => $donor]);
    }
}
