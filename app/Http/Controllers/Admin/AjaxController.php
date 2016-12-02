<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\LegalEntity;
use App\Models\Person;


use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class AjaxController extends Controller
{
    use \App\Traits\ControllerIndexTrait;


    public function cities($request)
    {

        $query = Input::get('q');

        $result = City::where('name', 'LIKE', '%' . $query . '%')->get();

        return response()
            ->json($result);
    }

    public function persons($request)
    {

        $input = Input::get('q');

        $result = Person::where('first_name', 'LIKE', '%' . $input . '%')->orWhere('last_name', 'LIKE', '%' . $input . '%')->get();

        return response()
            ->json($result);
    }


    public function entities($request)
    {

        $input = Input::get('q');

        $result = LegalEntity::where('name', 'LIKE', '%' . $input . '%')->get();


        return response()
            ->json($result);
    }

}
