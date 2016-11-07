<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\LegalEntity;
use App\Models\Person;


use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class LegalEntityController extends Controller
{
    use \App\Traits\ControllerIndexTrait;


    public function listing()
    {
        $entities = LegalEntity::paginate(15);
        return view('admin.legal-entity.listing', ['legalEntities' => $entities]);
    }

    public function create($request)
    {

        if(Request::isMethod('post')){
            $this->validate($request, [
                'name' => 'max:100',
                'tax_id' => 'required|max:30',
                'city_id' => 'required|max:5',
                'address' => 'required|unique:persons|max:100',
                'bank' => 'numeric',
                'bank_acc' => 'required|max:150',
                'contact_email' => 'unique:legal_entities|max:100',
                'contact_phone' => 'max:100',
                'representing_person' => 'numeric',


            ]);

            $person = LegalEntity::create(Input::all());

            if($person){
                return redirect('admin/legal-entity/listing');
            }else{
                dd("Not saved");
            }
        }else{

        }
        $banks = Bank::all();
        return view('admin.legal-entity.create', ['banks' => $banks]);
    }
}
