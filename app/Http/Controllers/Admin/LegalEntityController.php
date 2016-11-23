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

        if (Request::isMethod('post')) {
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

            $entity = LegalEntity::create(Input::all());

            if ($entity) {
                return redirect('admin/legal-entity/listing');
            }
        }
        $banks = Bank::select('name', 'id')->get()->toArray();
        $bankSrr = [];
        foreach ($banks as $b) {
            $bankSrr[$b['id']] = $b['name'];
        }

        return view('admin.legal-entity.create', ['banks' => $bankSrr]);
    }

    public function view($request, $id)
    {
        $entity = LegalEntity::find($id)->first();

        return view('admin.legal-entity.view', ['entity' => $entity]);
    }


    public function edit($request, $id)
    {
        $entity = LegalEntity::find($id);
        if (Request::isMethod('post')) {
            $this->validate($request, [
                'name' => 'max:100',
                'tax_id' => 'required|max:30',
                'city_id' => 'required|max:5',
                'address' => 'required|unique:persons|max:100',
                'bank' => 'numeric',
                'bank_acc' => 'required|max:150',
                'contact_email' => 'max:100',
                'contact_phone' => 'max:100',
                'representing_person' => 'numeric',


            ]);


            $input = Input::all();
            if ($entity->update($input)) {
                return redirect('admin/legal-entity/listing');
            }
        }
        $banks = Bank::select('name', 'id')->get()->toArray();
        $bankSrr = [];
        foreach ($banks as $b) {
            $bankSrr[$b['id']] = $b['name'];
        }

        return view('admin.legal-entity.edit', ['banks' => $bankSrr, 'entity' => $entity]);
    }
}
