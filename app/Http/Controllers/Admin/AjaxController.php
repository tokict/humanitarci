<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beneficiary;
use App\Models\City;
use App\Models\Group;
use App\Models\LegalEntity;
use App\Models\Organization;
use App\Models\Person;


use App\Http\Requests;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class AjaxController extends Controller
{
    use \App\Traits\ControllerIndexTrait;


    public function cities()
    {

        $query = Input::get('q');

        $result = City::where('name', 'LIKE', '%' . $query . '%')->get();
        foreach($result as $r){
            $r->region = $r->region;
        }
        return response()
            ->json($result);
    }

    public function persons()
    {

        $input = Input::get('q');

        $result = Person::where('first_name', 'LIKE', '%' . $input . '%')->orWhere('last_name', 'LIKE', '%' . $input . '%')->get();
        foreach($result as $r){
            $r->city = $r->city;
        }
        return response()
            ->json($result);
    }


    public function entities()
    {

        $input = Input::get('q');

        $result = LegalEntity::where('name', 'LIKE', '%' . $input . '%')->get();
        foreach($result as $r){
            $r->bank = $r->bank;
            $r->city = $r->city;
        }

        return response()
            ->json($result);
    }

    public function organizations()
    {

        $input = Input::get('q');

        $result = Organization::where('name', 'LIKE', '%' . $input . '%')->get();
        foreach($result as $r){
            $r->legalEntity = $r->legalEntity;
        }

        return response()
            ->json($result);
    }

    public function users()
    {

        $input = Input::get('q');

        $result = User::where('name', 'LIKE', '%' . $input . '%')->get();
        foreach($result as $r){
            $r->person = $r->person;
        }

        return response()
            ->json($result);
    }

    public function groups()
    {

        $input = Input::get('q');

        $result = Group::where('name', 'LIKE', '%' . $input . '%')->get();

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

}
