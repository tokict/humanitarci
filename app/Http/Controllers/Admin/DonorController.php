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
        $donors = Donor::paginate(50);
        return view('admin.donor.listing', ['donors' => $donors]);
    }

    public function view($request, $id)
    {

        $donor = Donor::find($id)->get()->first();



        return view('admin.donor.view', ['donor' => $donor]);
    }

}
