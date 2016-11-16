<?php

namespace App\Http\Controllers\Admin;
use App\Models\MediaLink;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Campaign;
use App\Models\Media;
use App\Models\Person;


use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class CampaignController extends Controller
{
    use \App\Traits\ControllerIndexTrait;


    public function listing()
    {
        $campaigns = Campaign::paginate(15);

        return view('admin.campaign.listing', ['campaigns' => $campaigns]);
    }

    public function create($request)
    {

        if(Request::isMethod('post')){
            $this->validate($request, [

                'name' => 'required|max:100',
                'beneficiary_id' => 'required|numeric',
                'organization_id' => 'required|max:3|numeric',
                'starts_time' => 'required_with:starts_date',
                'ends_time' => 'required_with:ends_date',
                'starts_date' => 'required_with:starts_time',
                'ends_date' => 'required_with:ends_time',
                'action_by_date' => 'required_with:action_by_time',
                'action_by_time' => 'required_with:action_by_date',
                'type' => 'required',
                'target_amount' => 'required|digits_between:3,6',
                'short_description' => 'required|max:500',
                'full_description' => 'required|max:2000',
                'status' => 'required',
                'priority' => 'numeric',
                'cover_photo_id' => 'required: exists:media,id'


            ]);


            $input = Input::all();
            $input['created_by'] = Auth::User()->id;
            $input['starts'] = date("Y-m-d H:i:s",strtotime($input['start_date']." ".$input['start_time']));
            $input['ends'] = date("Y-m-d H:i:s",strtotime($input['end_date']." ".$input['end_time']));
            $input['action_by_date'] = date("Y-m-d H:i:s",strtotime($input['action_by_date']." ".$input['action_by_time']));
            $input['media_info'] = $input['campaign_photos'];
            //Lets save cover_image if present

            $campaign = Campaign::create($input);
            if($campaign) {
                //Save media link
                $mediaLink = new MediaLink(
                    [
                        'campaign_id' => $campaign->id,
                        'media_id' => $input['cover_photo_id'],
                        'organization_id' => Auth::User()->organization_id,
                        'user_id' =>Auth::User()->id

                    ]
                );
                $mediaLink->save();

                if(isset($input['campaign_photos'])){
                    foreach(explode(",", $input['media_info']) as $id){
                        $file = Media::whereId($id);
                        if($file) {
                            $link = new MediaLink(
                                [
                                    'campaign_id' => $campaign->id,
                                    'media_id' => $id,
                                    'organization_id' => Auth::User()->organization_id,
                                    'user_id' => Auth::User()->id
                                ]
                            );
                            $link->save();
                        }
                    }
                }

                return redirect('admin/campaign/listing');
            }else{
                dd("Not saved");
            }


        }else{

        }
        return view('admin.campaign.create');
    }
}
