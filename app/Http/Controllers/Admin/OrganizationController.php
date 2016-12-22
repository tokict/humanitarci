<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\LegalEntity;
use App\Models\Organization;
use App\Models\Person;


use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class OrganizationController extends Controller
{
    use \App\Traits\ControllerIndexTrait;


    public function listing()
    {
        if (!Input::get('search')) {
            $order = Input::get('order');
            if ($order) {
                $sort = Input::get('dir');

                $organizations = Organization::orderBy($order, $sort)->paginate(20);

            } else {

                $organizations = Organization::paginate(20);

            }
        } else {
            $q = Input::get('search');
            $organizations = Organization::with('LegalEntity')->with('Person')->with('City')
                ->where('name', 'like', '%' . $q . '%')
                ->orWhere('contact_email', 'like', '%' . $q . '%')
                ->orWhere('contact_phone', 'like', '%' . $q . '%')
                ->orWhere('donations_address', 'like', '%' . $q . '%')
                ->orWhere('description', 'like', '%' . $q . '%')
                ->orWhereHas('LegalEntity', function ($x) use ($q) {
                    $x->where('name', 'like', '%' . $q . '%');
                })
                ->orWhereHas('Person', function ($x) use ($q) {
                    $x->where('first_name', 'like', '%' . $q . '%')->orWhere('last_name', 'like', '%' . $q . '%');
                })
                ->orWhereHas('City', function ($x) use ($q) {
                    $x->where('name', 'like', '%' . $q . '%');
                })->paginate(20);
        }
        return view('admin.organization.listing', ['organizations' => $organizations]);
    }

    public function create($request)
    {

        if (Request::isMethod('post')) {
            $this->validate($request, [
                'name' => 'max:100',
                'legal_entity_id' => 'required|numeric',
                'donations_address' => 'max:100',
                'donations_coordinates' => 'max:100',
                'description' => 'required',
                'contact_email' => 'max:100',
                'contact_phone' => 'max:100',
                'represented_by' => 'required',
                'status' => 'required|numeric',
                'city_id' => 'required|numeric',


            ]);

            $organization = Organization::create(Input::all());

            if ($organization) {
                return redirect('admin/organization/listing');
            } else {
                dd("Not saved");
            }
        } else {

        }
        $organization = new Organization([]);

        return view('admin.organization.create', ['organization' => $organization]);
    }

    public function view($request, $id)
    {

        $organization = Organization::find($id)->first();

        return view('admin.organization.view', ['organization' => $organization]);
    }

    public function edit($request, $id)
    {
        $organization = Organization::find($id);
        if (Request::isMethod('post')) {
            $this->validate($request, [
                'name' => 'max:100',
                'legal_entity_id' => 'required|numeric',
                'donations_address' => 'max:100',
                'donations_coordinates' => 'max:100',
                'description' => 'required',
                'contact_email' => 'max:100',
                'contact_phone' => 'max:100',
                'represented_by' => 'required',
                'status' => 'required',
                'city_id' => 'required|numeric',


            ]);

            $input = Input::all();

            if ($organization->update($input)) {
                return redirect('admin/organization/listing');
            } else {
                dd("Not saved");
            }
        } else {

        }

        return view('admin.organization.edit', ['organization' => $organization]);
    }
}
