<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Campaign;
use App\Models\Media;
use Illuminate\Http\Request;

class CampaignsController extends Controller
{
    use \App\Traits\ControllerIndexTrait;

    /**
     * Show campaign listings.
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
        $media_info = Media::whereIn('id', explode(",", $campaign->media_info))->get();
        $campaign->media_info = $media_info;

        return view('campaign.view', ['campaign' => $campaign]);
    }
}
