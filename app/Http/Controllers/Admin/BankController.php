<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Person;


use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class BankController extends Controller
{
    use \App\Traits\ControllerIndexTrait;


    public function listing()
    {
        $banks = Bank::paginate(15);

        return view('admin.bank.listing', ['banks' => $banks]);
    }

    public function create($request)
    {

        if(Request::isMethod('post')){
            $this->validate($request, [

                'name' => 'required|max:30',
                'swift_code' => 'required|max:30',
                'legal_entity_id' => 'required|numeric'

            ]);

            $bank = Bank::create(Input::all());
            if($bank){
                return redirect('admin/bank/listing');
            }else{
                dd("Not saved");
            }
        }else{

        }
        return view('admin.bank.create');
    }

    public function edit($request, $id)
    {
        $bank = Bank::find($id);
        if(Request::isMethod('post')){
            $this->validate($request, [

                'name' => 'required|max:30',
                'swift_code' => 'required|max:30',
                'legal_entity_id' => 'required|numeric'

            ]);

            $input = Input::all();
            if($bank->update($input)) {
                return redirect('admin/bank/listing');
            }
        }
        return view('admin.bank.edit', ['bank' => $bank]);
    }
}
