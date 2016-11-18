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

            if (isset($input['profile_image'])) {
                $media = new Media([]);
                $save = $media->saveFile($request->file('profile_image'), 'beneficiaries', 'public');
                if ($save) {
                    $media->setAtt('path', $save);
                    $media->setAtt('uploaded_by', Auth::User()->id);
                    $media->setAtt('type', 'campaign');

                    if ($media->save()) {
                        $input['profile_image_id'] = $media->id;
                    }
                }
            }


            $input['created_by_id'] = Auth::User()->id;
            $beneficiary = Beneficiary::create($input);
            if ($beneficiary) {
                //Save media link
                if ($media) {
                    $mediaLink = new MediaLink(
                        [
                            'beneficiary_id' => $beneficiary->id,
                            'media_id' => $media->id,
                            'organization_id' => Auth::User()->organization_id,
                            'user_id' => Auth::User()->user_id

                        ]
                    );
                    $mediaLink->save();
                }
                return redirect('admin/beneficiary/listing');
            } else {
                dd("Not saved");
            }
        }
        return view('admin.beneficiary.create');

    }

}
