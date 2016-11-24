<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\User;


class UsersController extends Controller
{
    use \App\Traits\ControllerIndexTrait;

    /**
     * Show donor listings.
     *
     * @return \Illuminate\Http\Response
     */
    public function registration()
    {   $donors = User::paginate(30);
        return view('user.list', ['donors' => $donors]);
    }

    /**
     * Show a single donor.
     *
     * @return \Illuminate\Http\Response
     */
    public function login($request, $id)
    {

        $campaign = User::whereId($id)->first();
        return view('user.view', ['donor' => $campaign]);
    }
}
