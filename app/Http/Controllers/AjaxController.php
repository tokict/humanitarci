<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use App\Models\City;
use App\Models\Donor;
use App\Models\Organization;
use App\Models\PasswordReset;
use App\Models\Person;


use App\Http\Requests;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class AjaxController extends Controller
{
    use \App\Traits\ControllerIndexTrait;
    use ResetsPasswords;


    public function cities()
    {

        $query = Input::get('q');

        $result = City::where('name', 'LIKE', '%' . $query . '%')->get();
        foreach ($result as $r) {
            $r->region = $r->region;
        }
        return response()
            ->json($result);
    }


    public function organizations()
    {

        $input = Input::get('q');

        $result = Organization::where('name', 'LIKE', '%' . $input . '%')->get();
        foreach ($result as $r) {
            $r->legalEntity = $r->legalEntity;
        }

        return response()
            ->json($result);
    }


    public function beneficiaries()
    {

        $input = Input::get('q');

        $result = Beneficiary::where('name', 'LIKE', '%' . $input . '%')->get();

        return response()
            ->json($result);
    }


    /**
     * Register new donor
     *
     * @return \Illuminate\Http\Response
     */
    public function registration($request, $params)
    {

        $this->validate($request, [
            'contact_email' => 'required|max:30|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'country' => 'required',


        ]);
        $input = Input::all();
        $user = User::whereEmail($input['contact_email'])->get()->first();
        if ($user) {
            //Create donor only
            if (!$user->donor) {
                $donor = new Donor;
                $donor->user_id = $user->id;
                $donor->save();
                if (isset($input['username'])) {
                    $user->username = $input['username'];
                    $user->save();
                }
            }
        } else {

            //Create person
            $existingUser = User::whereEmail($input['contact_email'])->get()->first();
            if ($existingUser) {
                return response()
                    ->json(['success' => true]);
            }


            //Create user and donor
            $uData = [
                'email' => $input['contact_email'],
            ];

            $existingPerson = Person::whereContactEmail($input['contact_email'])->get()->first();
            if ($existingPerson) {
                $uData['person_id'] = $existingPerson->id;
            } else {
                $person = new Person($input);
                $person->save();
                $uData['person_id'] = $person->id;
            }

            //Create user and send pass reset mail

            $user = \App\User::create($uData);

            //Send reset link
            $reset = new PasswordReset(['email' => $input['contact_email'], 'token' => Str::random(60)]);
            $reset->save();
            Mail::queue('emails.pay_registration', ['user' => $user, 'reset' => $reset->toArray()], function ($m) use ($user, $reset) {

                $m->to($user->email, $user->first_name)->subject('Set up your Humanitarci password');
            });

            $donor = Donor::create(['user_id' => $user->id, 'person_id' => $person->id]);
        }


    }

}
