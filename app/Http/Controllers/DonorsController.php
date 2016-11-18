<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Donor;


class DonorsController extends Controller
{
    use \App\Traits\ControllerIndexTrait;

    /**
     * Show donor listings.
     *
     * @return \Illuminate\Http\Response
     */
    public function listing()
    {   $donors = Donor::paginate(30);
        return view('donor.list', ['donors' => $donors]);
    }

    /**
     * Show a single donor.
     *
     * @return \Illuminate\Http\Response
     */
    public function view($request, $id)
    {

        $campaign = Donor::whereId($id)->first();
        return view('donor.view', ['donor' => $campaign]);
    }
}
