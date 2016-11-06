<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Person;


use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class AjaxController extends Controller
{
    use \App\Traits\ControllerIndexTrait;



    public function cities($request)
    {

       $query = Input::get('q');

        $result = City::where('name', 'LIKE', '%'.$query.'%')->get();

        foreach ($result as $item) {
            $item->region = $item->region;
        }

        return response()
            ->json($result);
    }
}
