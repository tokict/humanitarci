<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


use App\Http\Requests;
use App\Models\Admin;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Request;

class UserController extends Controller
{
    use \App\Traits\ControllerIndexTrait;
    use ResetsPasswords;


    public function listing()
    {

        if (!Input::get('search')) {
            $order = Input::get('order');
            if ($order) {
                $sort = Input::get('dir');
                $users = User::orderBy($order, $sort)->paginate(20);

            } else {

                $users = User::paginate(50);

            }
        } else {
            $q = Input::get('search');
            $users = User::with('Group')->with('Person')->with('LegalEntity')
                ->where('username', 'like', '%' . $q . '%')
                ->orWhere('email', $q)
                ->orWhereHas('Person', function ($x) use ($q) {
                    $x->where('first_name', 'like', '%' . $q . '%')->orWhere('last_name', 'like', '%' . $q . '%');
                })->paginate(20);
        }



        return view('admin.user.listing', ['users' => $users]);
    }

    public function create($request)
    {

        if(Request::isMethod('post')){
            $this->validate($request, [
                'organization_id' => 'required|numeric',
                'person_id' => 'required|numeric',
                'email' => 'required|email|unique:users',
                'username' => 'required|max:15'
            ]);

            $input = Input::all();
            $input['created_by'] = Auth::User()->admin->id;
            $input['password'] = str_random(15);
            $user = User::create($input);


            if($user){
                $admin = Admin::create([
                    'organization_id' => $input['organization_id'],
                    'user_id' => $user->id,
                    'super_admin' => isset($input['super_admin']),
                    'created_by' => $input['created_by']
                ]);

                $user->admin_id = $admin->id;
                $user->save();


                return redirect('admin/user/listing');
            }else{
                dd("Not saved");
            }
        }else{

        }

        return view('admin.user.create');
    }
}
