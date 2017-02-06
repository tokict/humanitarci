<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Campaign;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use \App\Traits\ControllerIndexTrait;

    /**
     * Show the main page.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $campaigns = Campaign::where('status', 'active')
            ->orderBy('priority', 'desc')
            ->orderBy('percent_done', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('welcome', ['campaigns' => $campaigns]);
    }
}
