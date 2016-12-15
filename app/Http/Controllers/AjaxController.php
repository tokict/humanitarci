<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use App\Models\City;
use App\Models\Donor;
use App\Models\Order;
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
                $donor->person_id = $user->person_id;
                $donor->save();
                $user->donor_id = $donor->id;
                $user->save();
            }
        } else {

            //Create person
            $existingUser = User::whereEmail($input['contact_email'])->get()->first();
            if ($existingUser) {
                return response()
                    ->json(['success' => true, 'message' => 'User exists']);
            }


            //Create user and donor
            $uData = [
                'email' => $input['contact_email'],
            ];

            $existingPerson = Person::whereContactEmail($input['contact_email'])->get()->first();
            if ($existingPerson) {
                $uData['person_id'] = $existingPerson->id;
            } else {
                $person = Person::create($input);

                $uData['person_id'] = $person->id;
            }

            //Create user

            $user = new User($uData);
            $user->save();


            $donor = Donor::create(['user_id' => $user->id, 'person_id' => $person->id]);

            $user->donor_id = $donor->id;
            $user->save();



        }
        //Update order with new donor id
        $order = Order::whereOrderToken($input['order_token'])->get()->first();

        $order->donor_id = $user->donor->id;
        $order->save();

        return response()
            ->json(['success' => true, 'message' => 'New user']);


    }

}
