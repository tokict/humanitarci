<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Donation;
use App\Models\Donor;


class DonationsController extends Controller
{
    use \App\Traits\ControllerIndexTrait;

    /**
     * Show donation listings.
     *
     * @return \Illuminate\Http\Response
     */
    public function listing()
    {   $donations = Donation::paginate(30);
        return view('donations.list', ['donations' => $donations]);
    }

    /**
     * Show a single donation.
     *
     * @return \Illuminate\Http\Response
     */
    public function view($request, $id)
    {

        $donation = Donor::whereId($id)->first();
        return view('donations.view', ['donation' => $donation]);
    }
}
