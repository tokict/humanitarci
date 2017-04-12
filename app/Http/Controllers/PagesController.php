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

            $this->validate($request, [
                'email' => 'required|email|max:100',
                'name' => 'required|max:100',
                'message' => 'required|max:1000',
                'g-recaptcha-response' => 'recaptcha',
            ]);
            $data = [
                'name' => Input::get('name'),
                'email' => Input::get('email'),
                'message' => Input::get('message')];

            Mail::queue('emails.contact_form',
                [
                    'data' =>
                        $data
                ],
                function ($m) {

                    $m->to(env('WEBMASTER_MAIL'), 'Tino')->subject('Kontakt preko Humanitarci.hr');
                });
            \Session::flash('success', true);

        }
        return view('pages.contacts');
    }

    public function faq(){
        return view('pages.faq');
    }
}
