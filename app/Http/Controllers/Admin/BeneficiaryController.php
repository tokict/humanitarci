<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beneficiary;
use App\Models\Person;


use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class BeneficiaryController extends Controller
{
    use \App\Traits\ControllerIndexTrait;


    public function listing()
    {
        $beneficiaries = Beneficiary::paginate(15);
        return view('admin.beneficiary.listing', ['beneficiaries' => $beneficiaries]);
    }

    public function create($request)
    {

        if(Request::isMethod('post')){
            $this->validate($request, [
                'name' => 'required|max:30',
                'contact_phone' => 'numeric',
                'contact_email' => 'unique:persons|max:100',
                'entity_id' => 'required_without_all:person_id, group_id',
                'person_id' => 'required_without_all:entity_id, group_id',
                'group_id' => 'required_without_all:person_id, entity_id',
                'status' => 'required',

            ]);

            $input = Input::all();
            $input['created_by_id'] = Auth::User()->id;
            $beneficiary = Beneficiary::create($input);
            if($beneficiary){
                return redirect('admin/beneficiary/listing');
            }else{
                dd("Not saved");
            }
        }else{

        }
        return view('admin.beneficiary.create');
    }
}
