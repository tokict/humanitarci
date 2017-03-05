<?php

/**
 * Created by PhpStorm.
 * User: tino
 * Date: 10/30/16
 * Time: 11:14 AM
 */

namespace App\Http\Controllers;


use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class ContactsController extends Controller
{
    /**
     * Store a new newsletter signup.
     *
     * @param  Request $request
     * @return Response
     */
    public function newsletterSignup(Request $request)
    {
        try {
            $validate = $this->validate($request, [
                'EMAIL' => 'required|email|max:100',
            ]);

            $write = file_put_contents('../newsletter.txt', "," . Input::get("EMAIL"), FILE_APPEND);

            if ($write) {
                return response()->json([
                    'result' => 'success',
                    'msg' => "Vaša email adresa je uspješno zapisana na listu"
                ])->setCallback(Input::get('c'));
            } else {
                return response()->json([
                    'result' => 'error',
                    'msg' => "Nastao je problem pri zapisivanju Vaše adrese. Molimo obavijestite administratora na email: info@humanitarci.hr"
                ]);
            }


        } catch (ValidationException $e) {
            return response()->json([
                'result' => 'error',
                'msg' => $e->getMessage()
            ]);
        }


        // The email is valid, store in database...
    }


}