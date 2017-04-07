<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use App\Models\City;
use App\Models\Donor;
use App\Models\LegalEntity;
use App\Models\Order;
use App\Models\Organization;
use App\Models\PagesData;
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
            ->json($result, 200, ['Content-type'=> 'application/json; charset=utf-8']);
    }


    public function organizations()
    {

        $input = Input::get('q');

        $result = Organization::where('name', 'LIKE', '%' . $input . '%')->get();
        foreach ($result as $r) {
            $r->legalEntity = $r->legalEntity;
        }

        return response()
            ->json($result, 200, ['Content-type'=> 'application/json; charset=utf-8']);
    }


    public function beneficiaries()
    {

        $input = Input::get('q');

        $result = Beneficiary::where('name', 'LIKE', '%' . $input . '%')->get();

        return response()
            ->json($result, 200, ['Content-type'=> 'application/json; charset=utf-8']);
    }


    /**
     * Register new donor
     *
     * @return \Illuminate\Http\Response
     */
    public function registration(\Illuminate\Http\Request $request)
    {

        $this->validate($request, [
            'contact_email' => 'required|max:30|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'payeeType' => 'required',
            'country' => 'required',
            'g-recaptcha-response' => 'recaptcha',


        ]);

        $input = Input::all();

        $user = User::whereEmail($input['contact_email'])->get()->first();
        if ($user) {
            //Create donor only
            if (!$user->donor) {
                $donor = new Donor;
                $donor->user_id = $user->id;
                if($input['payeeType'] == 'company'){
                    $donor->entity_id = $user->entity_id;
                }else{
                    $donor->person_id = $user->person_id;
                }

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


            //Create user, company and donor
            $uData = [
                'email' => $input['contact_email'],
            ];

            $existingPerson = Person::whereContactEmail($input['contact_email'])->get()->first();
            if ($existingPerson) {
                $uData['person_id'] = $existingPerson->id;
                $person = $existingPerson;
            } else {
                $person = Person::create($input);

                $uData['person_id'] = $person->id;
            }

            //Register a company if its a company donation
            if($input['payeeType'] == 'company'){
                $entity = new LegalEntity();
                $entity->name = $input['entity_name'];
                $entity->tax_id = $input['entity_tax_id'];
                $entity->city_id = $input['entity_city_id'];
                $entity->address = $input['entity_address'];
                $entity->represented_by = $uData['person_id'];
                $entity->contact_email = $uData['email'];
                $entity->contact_phone = $person->contact_phone;
                try{
                    $entity->save();
                }catch(\Exception $e){
                    dd($e->getMessage());
                }

                $uData['entity_id'] = $entity->id;
            }

            //Create user

            $user = new User($uData);
            $user->save();

            if($input['payeeType'] == 'company') {
                $donor = Donor::create(['user_id' => $user->id, 'entity_id' => $entity->id]);
            }else{
                $donor = Donor::create(['user_id' => $user->id, 'person_id' => $person->id]);
            }

            $user->donor_id = $donor->id;
            $user->save();


            //Update order with new donor id
            $order = Order::whereOrderToken($input['order_token'])->get()->first();

            $order->donor_id = $user->donor->id;
            $order->save();
        }


        return response()
            ->json(['success' => true, 'message' => 'New user']);


    }


    /**
     * Swithc payment type on saved order
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePaymentType()
    {
        $input = Input::all();
        $type = $input['type'];

        $type = ($type == 'bank')?'bank_transfer':'credit_card';

        $orderId = \Session::get('donations')[0]['order_id'];

        $order = Order::find($orderId);

        $order->payment_method = $type;
        if($order->update()){
            return response()
                ->json(['success' => true]);
        }else{
            return response()
                ->json(['success' => false]);
        }


    }


    /**
     * Log the sharing of the page to the db
     * @return \Illuminate\Http\JsonResponse
     */
    public function logShare()
    {
        $input = Input::all();

        $pageData = PagesData::where('page_id', $input['id'])->where('page_type', $input['type'])->get()->first();
        if($pageData){
            $pageData->shares = $pageData->shares + 1;
            $pageData->save();
        }else{
            PagesData::create([
                'page_id' => $input['id'],
                'page_type' => $input['type'],
                'shares' => 1
            ]);
        }
        return response()
            ->json(['success' => true]);

    }

    public function checkUser(){
        $email = Input::get('contact_email');

        $user = User::where('email', $email)->count();
        if($user){
            return response()
                ->json(['success' => false]);
        }else{
            return response()
                ->json(['success' => true]);
        }

    }

}
