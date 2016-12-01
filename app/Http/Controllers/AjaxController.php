<?php

namespace App\Http\Controllers;

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



    public function beneficiaries()
    {

        $input = Input::get('q');

        $result = Beneficiary::where('name', 'LIKE', '%' . $input . '%')->get();

        return response()
            ->json($result);
    }


    public function saveUser(){
        $input = Input::all();
        $city = City::find($input['city_id']);
        return response()->json(['city' => $city->name, 'region' => $city->region->name]);
    }

}
