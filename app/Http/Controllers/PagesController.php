<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

class PagesController extends Controller
{

    use \App\Traits\ControllerIndexTrait;

    public function team()
    {
        return view('pages.team');
    }

    public function history()
    {
        return view('pages.history');
    }

    public function mission()
    {
        return view('pages.mission');
    }

    public function media()
    {
        return view('pages.media');
    }

    public function contacts(Request $request)
    {
        if ($request->isMethod('post')) {
            try {
                $this->validate($request, [
                    'email' => 'required|email|max:100',
                    'name' => 'required|max:100',
                    'message' => 'required|max:1000',
                ]);

                 mail( env('WEBMASTER_MAIL') , 'New humanitarci.hr message' , Input::get('name').' - '.Input::get('email').'  |   '.Input::get('message')
                      );

               \Session::flash('success' , true);

            } catch (\Exception $e) {

            }
        }
        return view('pages.contacts');
    }
}
