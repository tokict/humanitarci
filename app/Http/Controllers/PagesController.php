<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Campaign;
use Illuminate\Http\Request;

class PagesController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaigns = Campaign::where('status', 'active')
        ->orderBy('priority', 'desc')
        ->take(3)
        ->get();

        return view('welcome', ['campaigns' => $campaigns]);
    }
}
