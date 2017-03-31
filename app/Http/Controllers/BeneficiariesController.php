<?php

namespace App\Http\Controllers;

use App\Events\PageViewed;
use App\Http\Requests;
use App\Models\Beneficiary;
use Illuminate\Validation\Validator;


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
        $v = \Illuminate\Support\Facades\Validator::make([
            'id' => $id
        ],[
            'id' => 'required|numeric'
        ]);
        if ($v->fails())
        {
            abort(404, trans('errors.Beneficiary not found!'));
        }


        $beneficiary = Beneficiary::whereId($id)->first();
        event(new PageViewed(['type' => 'beneficiary', 'id' => $id]));
        $page = new \stdClass();
        $page->description = $beneficiary->description;
        $page->title = $beneficiary->name;
        $page->image = $beneficiary->profile_image->getPath('medium');
        $page->url = '/'.trans('routes.front.beneficiaries').'/'.trans('routes.actions.view').'/'.$beneficiary->id;
        return view('beneficiary.view', ['beneficiary' => $beneficiary, 'page' => $page]);
    }
}
