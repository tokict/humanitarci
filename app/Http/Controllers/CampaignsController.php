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


        if (isset($category) && trans('routes.campaignTypes.' . $category) != 'all') {

            if(trans('routes.parameters.'.$category) == 'popular'){
                $campaigns = Campaign::where('status', 'active')->get();


                foreach ($campaigns as &$campaign) {
                    $shares = $campaign->page_data->shares * 10;
                    $views = $campaign->page_data->views;
                    $donations = $campaign->donations->where('status', 'received')->count() * 100;
                    $campaign->score = $shares+$views+$donations;
                }

                $campaigns = $campaigns->sortBy('score')->reverse();

            }else {

                $campaigns = Campaign::where('category', trans('routes.campaignTypes.' . $category))
                    ->where('status', 'active')->paginate(30);
            }
        }else{
            $campaigns = Campaign::paginate(30);
        }

        foreach ($campaigns as $campaign) {
            $media_info = Media::whereIn('id', explode(",", $campaign->media_info))
                ->get();
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
