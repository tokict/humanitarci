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
        $organizations = Organization::paginate(100);
        return view('admin.organization.listing', ['organizations' => $organizations]);
    }

    public function create($request)
    {

        if(Request::isMethod('post')){
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



            ]);//ToDo: File uploader for logo

            $organization = Organization::create(Input::all());

            if($organization){
                return redirect('admin/organization/listing');
            }else{
                dd("Not saved");
            }
        }else{

        }

        return view('admin.organization.create');
    }
}
