<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beneficiary;
use App\Models\City;
use App\Models\Group;
use App\Models\LegalEntity;
use App\Models\Media;
use App\Models\MediaLink;
use App\Models\Organization;
use App\Models\Person;


use App\Http\Requests;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class FileController extends Controller
{
    use \App\Traits\ControllerIndexTrait;

    protected $s3;

    public function __construct()
    {
        $this->s3 = $s3 = \Storage::disk('s3');
    }

    public function open($request, $folder)
    {
        $filterType = Input::get("filterType", null);
        $filterType = $filterType == "all" ? null : $filterType;
        $sort = Input::get("sort", 'latest') == 'latest' ? 'DESC' : 'ASC';
        $page = Input::get("page", 1);
        $search = Input::get("search", null);
        $search = $search == "" ? null : $search;
        $folder = strtolower($folder);

        $folders['campaigns'] = [];
        $folders['beneficiaries'] = [];
        $folders['companies'] = [];
        $folders['people'] = [];
        $folders['documents '] = [];
        $folders['other'] = [];
        if (!isset($folders[$folder])) {
            die('Go away!');
        }

        /*CAMPAIGNS*/

        $data = Media::where('uploaded_by', Auth::User()->id)
            ->where('directory', $folder);
        if (isset($search)) {
            $data->where('title', 'like', '%' . $search . '%');
        }

        if (isset($filterType)) {
            $data->where('type', $filterType);
        }
        $data->orderBy('created_at', $sort);
        $folders[$folder] = $data->paginate(30);


        return view('admin.common.filemanager', [
            'folders' => $folders,
            'active' => $folder,
            'type' => $filterType,
            'sort' => $sort,
            'search' => $search
        ]);
    }


    public function readDir()
    {
        return $this->s3->directories("");
    }

    public function adminUpload($request, $category)
    {
        $fails = 0;
        foreach ($request->file('files') as $file) {
            $media = new Media([]);

            $save = $media->saveFile($file, $category . "/" . Auth::User()->organization_id, 'public');
            $type = "document";

            if (in_array($file->getClientOriginalExtension(), ['jpg', 'JPG', 'jpeg', 'png', 'PNG'])) {
                $type = 'image';
            }


            if ($save) {
                $media->setAtt('reference', $save);
                $media->setAtt('uploaded_by', Auth::User()->id);
                $media->setAtt('type', $type);
                $media->setAtt('directory', $category);

                if ($media->save()) {
                    $input['cover_photo_id'] = $media->id;
                } else {
                    $fails++;
                }

            }
        }

        return response()->json(['success' => $fails < 1 ? true : false]);
    }


    public function delete($request, $id)
    {
        $file = Media::whereId($id)->first();


        if ($file && count($file->links) == 0 && $file->uploaded_by == Auth::User()->id) {
            //File has no links and we can delete it from db and s3
            //Delete from s3
            if ($this->s3->delete($id)) {
                if ($file->delete()) {
                    $this->s3->delete("small_" . $id);
                    $this->s3->delete("medium_" . $id);
                    $this->s3->delete("large_" . $id);
                    $this->s3->delete("original_" . $id);
                    return response()->json(['success' => true]);
                }
            }
            return response()->json(['success' => false]);

        }

    }


    public function edit($request, $id)
    {
        $file = Media::whereId($id)->first();
        if ($file->uploaded_by == Auth::User()->id) {

            $file->title = Input::get('title');
            $file->description = Input::get('description');

            if ($file->save()) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }
        }

    }


}


