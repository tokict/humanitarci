<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Group;
use App\Models\Person;


use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class GroupController extends Controller
{
    use \App\Traits\ControllerIndexTrait;


    public function listing()
    {
        $groups = Group::paginate(15);

        return view('admin.group.listing', ['groups' => $groups]);
    }

    public function create($request)
    {

        if(Request::isMethod('post')){
            $this->validate($request, [
                'name' => 'required|max:30',
                'description' => 'required|max:30',
                'representing_person_id' => 'required_without:representing_entity_id|numeric',
                'representing_entity_id' => 'required_without:representing_person_id|numeric'

            ]);
            $input = Input::all();
            $input['owned_by'] = Auth::User()->admin->organization->id;

            $group = Group::create($input);
            if($group){
                return redirect('admin/group/listing');
            }else{
                dd("Not saved");
            }
        }else{

        }
        return view('admin.group.create');
    }

    public function edit($request, $id)
    {
        $group = Group::find($id);
        if(Request::isMethod('post')){
            $this->validate($request, [
                'name' => 'required|max:30',
                'description' => 'required|max:30',
                'representing_person_id' => 'required_without:representing_entity_id|numeric',
                'representing_entity_id' => 'required_without:representing_person_id|numeric'
            ]);

            $input = Input::all();
            if($group->update($input)) {
                return redirect('admin/group/listing');
            }
        }
        return view('admin.group.edit', ['group' => $group]);
    }
}
