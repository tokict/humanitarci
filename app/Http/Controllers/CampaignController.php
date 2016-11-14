<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    use \App\Traits\ControllerIndexTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show then campaign listings.
     *
     * @return \Illuminate\Http\Response
     */
    public function listing()
    {
        return view('campaign.list');
    }

    /**
     * Show a single campaign.
     *
     * @return \Illuminate\Http\Response
     */
    public function view($request, $id)
    {

        $campaign = Campaign::whereId($id)->first();
        return view('campaign.view', ['campaign' => $campaign]);
    }
}
