<?php

namespace App\Http\Controllers\Admin;

use App\Models\MediaLink;
use App\Models\MonetaryOutput;
use Illuminate\Support\Facades\Log;
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
        if (!Input::get('search')) {
            $order = Input::get('order');
            if ($order) {
                $sort = Input::get('dir');
                if (!Auth::User()->super_admin) {
                    $campaigns = Campaign::where('organization_id', Auth::User()->admin->organization_id)->orderBy($order, $sort)->paginate(50);
                } else {
                    $campaigns = Campaign::orderBy($order, $sort)->paginate(20);
                }
            } else {

                if (!Auth::User()->super_admin) {
                    $campaigns = Campaign::where('organization_id', Auth::User()->admin->organization_id)->paginate(50);
                } else {
                    $campaigns = Campaign::paginate(20);
                }
            }
        } else {
            $q = Input::get('search');
            $campaigns = Campaign::with('Beneficiary')->with('Organization')
                ->where('name', 'like', '%' . $q . '%')
                ->orWhere('description_short', 'like', '%' . $q . '%')
                ->orWhere('description_full', 'like', '%' . $q . '%')
                ->orWhere('slug', 'like', '%' . $q . '%')
                ->orWhere('reference_id', 'like', '%' . $q . '%')
                ->orWhere('end_notes', 'like', '%' . $q . '%')
                ->orWhere('registration_code', 'like', '%' . $q . '%')
                ->orWhereHas('Organization', function ($x) use ($q) {
                    $x->where('name', 'like', '%' . $q . '%');
                })
                ->orWhereHas('Beneficiary', function ($x) use ($q) {
                    $x->where('name', 'like', '%' . $q . '%');
                })->paginate(20);
        }


        return view('admin.campaign.listing', ['campaigns' => $campaigns]);
    }

    public function view($request, $id)
    {

        $campaign = Campaign::whereId($id)->get()->first();

        $media_info = Media::whereIn('id', explode(",", $campaign->media_info))->get();
        $campaign->campaign_media = $media_info;
        return view('admin.campaign.view', ['campaign' => $campaign]);
    }

    public function create($request)
    {

        if (Request::isMethod('post')) {
            $this->validate($request, [

                'name' => 'required|max:100',
                'beneficiary_id' => 'required|numeric',
                'organization_id' => 'required|numeric',
                'starts_time' => 'required_with:starts_date',
                'ends_time' => 'required_with:ends_date',
                'starts_date' => 'required_with:starts_time',
                'ends_date' => 'required_with:ends_time',
                'action_by_date' => 'required_with:action_by_time',
                'action_by_time' => 'required_with:action_by_date',
                'type' => 'required',
                'target_amount' => 'digits_between:3,6',
                'description_short' => 'required|max:300',
                'description_full' => 'required|max:5000',
                'status' => 'required',
                'registration_doc_id' => 'required|numeric',
                'registration_code' => 'required|max:20',
                'classification_code' => 'required|max:20',
                'priority' => 'numeric',
                'cover_photo_id' => 'required: exists:media,id'
            ]);


            $input = Input::all();
            $input['created_by_id'] = Auth::User()->id;
            $input['target_amount'] = $input['target_amount'] * 100;
            $input['starts'] = date("Y-m-d H:i:s", strtotime($input['start_date']));
            $input['ends'] = date("Y-m-d H:i:s", strtotime($input['end_date']));
            $input['action_by_date'] = date("Y-m-d H:i:s",
                strtotime($input['action_by_date']));

            //Lets save cover_image if presentc

            $campaign = Campaign::create($input);
            if ($campaign) {
                //Save media link
                $mediaLink = new MediaLink(
                    [
                        'campaign_id' => $campaign->id,
                        'media_id' => $input['cover_photo_id'],
                        'organization_id' => Auth::User()->admin->organization_id,
                        'user_id' => Auth::User()->id

                    ]
                );
                $mediaLink->save();

                /*Save documents*/
                $registration_doc = new MediaLink(
                    [
                        'campaign_id' => $campaign->id,
                        'media_id' => $input['registration_doc_id'],
                        'organization_id' => Auth::User()->admin->organization_id,
                        'user_id' => Auth::User()->id

                    ]
                );
                $registration_doc->save();

                /*End save documents*/

                if (isset($input['media_info'])) {
                    foreach (explode(",", $input['media_info']) as $id) {
                        $file = Media::whereId($id);
                        if ($file) {
                            $link = new MediaLink(
                                [
                                    'campaign_id' => $campaign->id,
                                    'media_id' => $id,
                                    'organization_id' => Auth::User()->admin->organization_id,
                                    'user_id' => Auth::User()->id
                                ]
                            );
                            $link->save();
                        }
                    }
                }

                return redirect('admin/campaign/listing');
            } else {
                dd("Not saved");
            }


        } else {

        }
        $campaign = new Campaign([]);
        return view('admin.campaign.create', ['campaign' => $campaign]);
    }


    public function edit($request, $id)
    {
        $campaign = Campaign::find($id);
        $old_cover_id = $campaign->cover_photo_id;
        $old_media_info = $campaign->media_info;


        if (!$campaign) {
            abort(404);
        }

        if (Request::isMethod('post')) {
            $this->validate($request, [

                'name' => 'required|max:100',
                'beneficiary_id' => 'required|numeric',
                'organization_id' => 'required|numeric',
                'starts_date' => 'required_with:starts_time',
                'ends_date' => 'required_with:ends_time',
                'action_by_date' => 'required_with:action_by_time',
                'type' => 'required',
                'target_amount' => 'digits_between:3,6',
                'description_short' => 'required|max:300',
                'description_full' => 'required|max:50000',
                'status' => 'required',
                'priority' => 'numeric',
                'cover_photo_id' => 'required: exists:media,id'
            ]);


            $input = Input::all();
            $input['created_by'] = Auth::User()->id;
            $input['starts'] = date("Y-m-d H:i:s", strtotime($input['start_date']));
            $input['ends'] = date("Y-m-d H:i:s", strtotime($input['end_date']));
            $input['action_by_date'] = date("Y-m-d H:i:s",
                strtotime($input['action_by_date']));


            if ($campaign->update($input)) {
                //Recheck and rebind media links and media
                if ($old_cover_id != $input['cover_photo_id']) {
                    $oldCover = MediaLink::where('campaign_id', $campaign->id)->where('media_id', $old_cover_id);
                    //Delete old cover
                    $oldCover->delete();

                    //Create new cover
                    $mediaLink = new MediaLink(
                        [
                            'campaign_id' => $campaign->id,
                            'media_id' => $input['cover_photo_id'],
                            'organization_id' => Auth::User()->admin->organization_id,
                            'user_id' => Auth::User()->id

                        ]
                    );
                    $mediaLink->save();
                }


                if ($old_media_info != $input['media_info']) {
                    $diff = array_diff(explode(",", $old_media_info), explode(",", $input['media_info']));
                    foreach (explode(",", $input['media_info']) as $id) {
                        $exists = MediaLink::where('campaign_id', $campaign->id)->where('media_id', $id);

                        //Add new ones
                        if (!$exists) {
                            $file = Media::whereId($id);
                            if ($file) {
                                $link = new MediaLink(
                                    [
                                        'campaign_id' => $campaign->id,
                                        'media_id' => $id,
                                        'organization_id' => Auth::User()->admin->organization_id,
                                        'user_id' => Auth::User()->id
                                    ]
                                );
                                $link->save();
                            }
                        }
                    }

                    //Remove links that are now not needed
                    foreach ($diff as $d) {
                        $link = MediaLink::where('campaign_id', $campaign->id)->where('media_id', $d);
                        $link->delete();
                    }
                }

                return redirect('admin/campaign/listing');


            }
        }

        $media_info = Media::whereIn('id', explode(",", $campaign->media_info))->get();
        $campaign->campaign_media = $media_info;
        return view('admin.campaign.edit', ['campaign' => $campaign]);


    }


    /**
     * Take some funds from the campaign for expenses or distribution
     * @param $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function take($request, $id)
    {
        $campaign = Campaign::whereId($id)->get()->first();
        if (!$campaign) {
            abort(404);
        }


        if (Request::isMethod('post')) {
            $this->validate($request, [
                'campaign_id' => 'required',
                'amount' => 'required|numeric',
                'description' => 'required',
                'receiving_entity_id' => 'required_without:expenses_payment|numeric|nullable',
                'receiving_person_id' => 'required_with:expenses_payment|numeric|nullable',
                'beneficiary_payment',
                'receipt_ids' => 'required'
            ]);
            $input = Input::all();

            if ($input['amount'] > $campaign->current_funds) {
                //User is not able to submit amount higher than current amount so its ok to die
                abort(500, 'Cannot take more money than donated');
            }


            //We calculate all without floating point
            $input['amount'] = $input['amount'] * 100;
            $input['action_time'] = date("Y-m-d H:i:s",
                strtotime($input['action_date']));

            $output = new MonetaryOutput($input);
            if (!$output->save()) {
                Log::error('Could not save monetary output!',
                    [
                        'campaign ID' => $campaign->id,
                        'amount' => $input['amount'],
                        'remaining amount' => $campaign->current_funds,
                        'user' => Auth::User()->id,
                    ]
                );
            } else {
                session()->flash('success', 'Amount successfully taken!');
            }
        }


        return view('admin.campaign.take', ['campaign' => $campaign]);
    }


    /**
     * Mark the campaign as finished, upload beneficiary signed docs and mark the funds for transfer to next campaign
     * @param $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finalize($request, $id)
    {
        $campaign = Campaign::whereId($id)->get()->first();
        if (!$campaign) {
            abort(404);
        }

        if (Request::isMethod('post')) {
            $this->validate($request, [
                'campaign_id' => 'required',
                'end_notes' => 'required',
                'beneficiary_receipt_doc_id' => 'required',
                'action_date' => 'required',
                'action_time' => 'required'
            ]);
            $input = Input::all();

            if (isset($input['end_media_info'])) {
                foreach (explode(',', $input['end_media_info']) as $id) {
                    $doc = Media::whereId($id)->get();
                    if (!$doc) {
                        session()->flash('error', 'Referenced media ID does not exist in the DB!');
                    }

                    $link = new MediaLink(
                        [
                            'campaign_id' => $campaign->id,
                            'media_id' => $id,
                            'organization_id' => Auth::User()->admin->organization_id,
                            'user_id' => Auth::User()->id

                        ]
                    );
                    $link->save();
                }
            }
            $campaign->end_notes = $input['end_notes'];
            $campaign->end_media_info = $input['end_media_info'];
            $campaign->finalized_at = date("Y-m-d H:i:s", strtotime($input['action_date'] . " " . $input['action_time']));
            $campaign->status = 'finalized';
            $campaign->update();

        }


        return view('admin.campaign.finalize', ['campaign' => $campaign]);
    }
}
