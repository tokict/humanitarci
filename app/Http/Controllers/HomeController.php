<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Campaign;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaigns = Campaign::where('status', 'active')
        ->orderBy('created_at', 'desc')
        ->take(3)
        ->get();

        return view('welcome', ['campaigns' => $campaigns]);
    }
}
