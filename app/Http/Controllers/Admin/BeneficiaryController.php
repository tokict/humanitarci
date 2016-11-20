<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beneficiary;
use App\Models\Media;
use App\Models\MediaLink;
use App\Models\Person;


use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class BeneficiaryController extends Controller
{
    use \App\Traits\ControllerIndexTrait;


    public function listing()
    {
        $beneficiaries = Beneficiary::paginate(15);
        return view('admin.beneficiary.listing', ['beneficiaries' => $beneficiaries]);
    }

    public function view($request, $id)
    {
        if (!$this->User->isSuperAdmin()) {
            $beneficiary = Beneficiary::where('creator.organization_id', $this->User->organization_id)
                ->where('beneficiary_id', $id)->paginate(50);
        } else {
            $beneficiary = Beneficiary::whereId($id);
        }


        return view('admin.beneficiary.view', ['beneficiary' => $beneficiary]);
    }

    public function create($request)
    {

        if (Request::isMethod('post')) {
            $this->validate($request, [
                'name' => 'required|max:30',
                'contact_phone' => 'numeric',
                'contact_email' => 'unique:persons|max:100',
                'entity_id' => 'required_without_all:person_id, group_id',
                'person_id' => 'required_without_all:entity_id, group_id',
                'group_id' => 'required_without_all:person_id, entity_id',
                'status' => 'required'

            ]);

            $input = Input::all();

            $input['created_by_id'] = Auth::User()->id;
            $beneficiary = Beneficiary::create($input);
            if ($beneficiary) {
                //Save media link

                $mediaLink = new MediaLink(
                    [
                        'beneficiary_id' => $beneficiary->id,
                        'media_id' => $input['profile_photo_id'],
                        'organization_id' => Auth::User()->organization_id,
                        'user_id' => Auth::User()->user_id

                    ]
                );
                $mediaLink->save();

                if (isset($input['media_info'])) {
                    foreach (explode(",", $input['media_info']) as $id) {
                        $file = Media::whereId($id);
                        if ($file) {
                            $link = new MediaLink(
                                [
                                    'beneficiary_id' => $beneficiary->id,
                                    'media_id' => $id,
                                    'organization_id' => Auth::User()->organization_id,
                                    'user_id' => Auth::User()->id
                                ]
                            );
                            $link->save();
                        }
                    }
                }

                return redirect('admin/beneficiary/listing');
            } else {
                dd("Not saved");
            }
        }
        $beneficiary = new Beneficiary([]);
        return view('admin.beneficiary.create', ['beneficiary' => $beneficiary]);

    }

    public function edit($request, $id)
    {
        $beneficiary = Beneficiary::find($id);
        $old_profile_img = isset($beneficiary->profile_image) ? $beneficiary->profile_image->id : null;
        if (Request::isMethod('post')) {
            $this->validate($request, [
                'name' => 'required|max:30',
                'contact_phone' => 'numeric',
                'contact_email' => 'unique:persons|max:100',
                'entity_id' => 'required_without_all:person_id, group_id',
                'person_id' => 'required_without_all:entity_id, group_id',
                'group_id' => 'required_without_all:person_id, entity_id',
                'status' => 'required',
                'profile_image' => 'numeric:required'

            ]);

            $input = Input::all();
            if ($beneficiary->update($input)) {
                //Save media link
                if ($old_profile_img && $old_profile_img != $beneficiary->profile_image->id) {
                    $mediaLink = new MediaLink(
                        [
                            'beneficiary_id' => $beneficiary->id,
                            'media_id' => $beneficiary->prodile_image->id,
                            'organization_id' => Auth::User()->organization_id,
                            'user_id' => Auth::User()->user_id

                        ]
                    );
                    $mediaLink->save();

                    //Delete old one
                    $oldLink = MediaLink::find($old_profile_img);
                    $oldLink->delete();
                }
                return redirect('admin/beneficiary/listing');
            }
        }
        $media_info = Media::whereIn('id', explode(",", $beneficiary->media_info))->get();
        $beneficiary->beneficiary_media= $media_info;
        return view('admin.beneficiary.edit', ['beneficiary' => $beneficiary]);

    }

}
