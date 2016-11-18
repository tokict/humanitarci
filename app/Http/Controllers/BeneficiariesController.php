<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Beneficiary;


class BeneficiariesController extends Controller
{
    use \App\Traits\ControllerIndexTrait;

    /**
     * Show then campaign listings.
     *
     * @return \Illuminate\Http\Response
     */
    public function listing()
    {
        $beneficiaries = Beneficiary::paginate(30);
        return view('donor.list', ['beneficiaries' => $beneficiaries]);
    }

    /**
     * Show a single beneficiary.
     *
     * @return \Illuminate\Http\Response
     */
    public function view($request, $id)
    {

        $beneficiary = Beneficiary::whereId($id)->first();
        return view('beneficiary.view', ['beneficiary' => $beneficiary]);
    }
}
