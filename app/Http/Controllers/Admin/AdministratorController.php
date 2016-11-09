<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Bank;
use App\Models\LegalEntity;
use App\Models\Organization;
use App\Models\Person;


use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class AdministratorController extends Controller
{
    use \App\Traits\ControllerIndexTrait;


    public function listing()
    {
        $administrators = Admin::paginate(100);
        return view('admin.administrator.listing', ['administrators' => $administrators]);
    }

    public function create($request)
    {

        if(Request::isMethod('post')){
            $this->validate($request, [
                'organization_id' => 'required|numeric',
                'user_id' => 'required|numeric',




            ]);//ToDo: File uploader for logo

            $input = Input::all();
            $input['created_by'] = Auth::User()->id;
            $administrator = Admin::create($input);

            if($administrator){
                return redirect('admin/administrator/listing');
            }else{
                dd("Not saved");
            }
        }else{

        }

        return view('admin.administrator.create');
    }
}
