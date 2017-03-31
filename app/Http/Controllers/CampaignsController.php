<?php

namespace App\Http\Controllers;

use App\Events\PageViewed;
use App\Http\Requests;
use App\Models\Campaign;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

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
        $v = \Illuminate\Support\Facades\Validator::make([
            'category' => $category
        ],[
            'category' => 'required'
        ]);
        if ($v->fails())
        {
            abort(404, trans('errors.Category not found!'));
        }

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
        $v = \Illuminate\Support\Facades\Validator::make([
            'id' => $id
        ],[
            'id' => 'required'
        ]);
        if ($v->fails())
        {
            abort(404, trans('errors.Campaign not found!'));
        }


        $campaign = Campaign::whereId($id)->first();
        $media_info = Media::whereIn('id', explode(",", $campaign->media_info))->get();
        $campaign->media_info = $media_info;
        event(new PageViewed(['type' => 'campaign', 'id' => $id]));

        $page = new \stdClass();
        $page->description = $campaign->description_short;
        $page->title = $campaign->name;
        $page->image = $campaign->cover->getPath('medium');
        $page->url = '/'.trans('routes.front.campaigns').'/'.trans('routes.actions.view').'/'.$campaign->id;

        return view('campaign.view', ['campaign' => $campaign, 'page' => $page]);
    }
}
