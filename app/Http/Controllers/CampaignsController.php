<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Campaign;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CampaignsController extends Controller
{
    use \App\Traits\ControllerIndexTrait;

    /**
     * Show campaign listings.
     *
     * @return \Illuminate\Http\Response
     */
    public function listing($request, $category)
    {


        if (isset($category) && trans('routes.campaignTypes.' . $category) != 'all') {
            $campaigns = Campaign::where('category', trans('routes.campaignTypes.' . $category))->paginate(30);
        }else{
            $campaigns = Campaign::paginate(30);
        }

        foreach ($campaigns as $campaign) {
            $media_info = Media::whereIn('id', explode(",", $campaign->media_info))->get();
            $campaign->media_info = $media_info;
        }
        return view('campaign.list', ['campaigns' => $campaigns]);
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
