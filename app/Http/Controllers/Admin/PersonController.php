<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Person;


use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class PersonController extends Controller
{
    use \App\Traits\ControllerIndexTrait;


    public function listing()
    {
        $persons = Person::paginate(15);
        return view('admin.person.listing', ['persons' => $persons]);
    }

    public function create($request)
    {

        if(Request::isMethod('post')){
            $this->validate($request, [
                'title' => 'max:15',
                'first_name' => 'required|max:30',
                'middle_name' => 'max:30',
                'last_name' => 'required|max:30',
                'social_id' => 'required|unique:persons|max:30',
                'city_id' => 'required|numeric',
                'address' => 'required|max:100',
                'contact_phone' => 'numeric',
                'contact_email' => 'unique:persons|max:100',
                'gender' => 'required|max:1|numeric',
                'bank_id' => 'max:2|numeric',
                'bank_acc' => 'required_with:bank_id|unique:persons|max:50'
            ]);

            $person = Person::create(Input::all());
            if($person){
                return redirect('admin/person/listing');
            }else{
                dd("Not saved");
            }
        }else{

        }
        return view('admin.person.create');
    }
}
