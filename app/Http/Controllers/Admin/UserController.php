<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\LegalEntity;
use App\Models\Organization;
use App\Models\Person;


use App\Http\Requests;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class UserController extends Controller
{
    use \App\Traits\ControllerIndexTrait;


    public function listing()
    {
        $users = User::paginate(100);
        return view('admin.user.listing', ['users' => $users]);
    }

    public function create($request)
    {

        if(Request::isMethod('post')){
            $this->validate($request, [
                'organization_id' => 'required|numeric',
                'user_id' => 'required|numeric',




            ]);

            $input = Input::all();
            $input['created_by'] = Auth::User()->id;
            $administrator = User::create($input);

            if($administrator){
                return redirect('admin/user/listing');
            }else{
                dd("Not saved");
            }
        }else{

        }

        return view('admin.user.create');
    }
}
