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
        if (!Input::get('search')) {
            $order = Input::get('order');
            if ($order) {
                $sort = Input::get('dir');

                $entities = LegalEntity::orderBy($order, $sort)->paginate(20);

            } else {

                $entities = LegalEntity::paginate(20);

            }
        } else {
            $q = Input::get('search');
            $entities = LegalEntity::with('City')
                ->with('Bank')
                ->with('Beneficiary')
                ->with('Organization')
                ->with('Person')
                ->with('Donor')
                ->where('name', 'like', '%' . $q . '%')
                ->orWhere('tax_id', 'like', '%' . $q . '%')
                ->orWhere('address', 'like', '%' . $q . '%')
                ->orWhere('bank_acc', 'like', '%' . $q . '%')
                ->orWhere('contact_phone', 'like', '%' . $q . '%')
                ->orWhere('contact_email', 'like', '%' . $q . '%')
                ->orWhereHas('Organization', function ($x) use ($q) {
                    $x->where('name', 'like', '%' . $q . '%');
                })
                ->orWhereHas('Bank', function ($x) use ($q) {
                    $x->where('name', 'like', '%' . $q . '%');
                })
                ->orWhereHas('Beneficiary', function ($x) use ($q) {
                    $x->where('name', 'like', '%' . $q . '%');
                })
                ->orWhereHas('Person', function ($x) use ($q) {
                    $x->where('first_name', 'like', '%' . $q . '%')->orWhere('last_name', 'like', '%' . $q . '%');
                })->paginate(20);
        }
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
                'bank_acc' => 'max:150',
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
