<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Campaign;
use Illuminate\Http\Request;

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

    public function contacts()
    {
        return view('pages.contacts');
    }
}
