<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donor;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class DonorController extends Controller
{
    use \App\Traits\ControllerIndexTrait;


    public function listing()
    {
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
            $donors = Donor::with('Person')->with('Entity')->with('User')
                ->whereHas('Person', function ($x) use ($q) {
                    $x->where('first_name', 'like', '%' . $q . '%')->orWhere('last_name', 'like', '%' . $q . '%');
                })
                ->orWhereHas('Entity', function ($x) use ($q) {
                    $x->where('name', 'like', '%' . $q . '%');
                })
                ->orWhereHas('User', function ($x) use ($q) {
                    $x->where('username', 'like', '%' . $q . '%');
                })->paginate(20);
        }

        return view('admin.donor.listing', ['donors' => $donors]);
    }

    public function view($request, $id)
    {

        $donor = Donor::find($id)->get()->first();


        return view('admin.donor.view', ['donor' => $donor]);
    }

}
