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


        $files = Media::where('uploaded_by', '=', Auth::User()->id)->get();
        //I do this because for some reason I cannot call Eloquent query in foreach
        foreach ($files as $file) {
            $folders[$file->directory][] = $file;

        }

        return view('admin.common.filemanager', ['folders' => $folders, 'active' => $folder]);
    }


    public function readDir()
    {
        return $this->s3->directories("");
    }

    public function upload($request, $folder)
    {
        $fails = 0;
        foreach ($request->file('files') as $file) {
            $media = new Media([]);

            $save = $media->saveFile($file, $folder, 'public');
            $type = "document";

            if (in_array($file->getClientOriginalExtension(), ['jpg','JPG' ,'jpeg', 'png', 'PNG'])) {
                $type = 'image';
            }


            if ($save) {
                $media->setAtt('reference', $save);
                $media->setAtt('uploaded_by', Auth::User()->id);
                $media->setAtt('type', $type);
                $media->setAtt('directory', $folder);

                if ($media->save()) {

                    $input['cover_photo_id'] = $media->id;

                    //Save media link
                    $mediaLink = new MediaLink(
                        [
                            'media_id' => $media->id,
                            'organization_id' => Auth::User()->organization_id,
                            'user_id' => Auth::User()->id

                        ]
                    );
                    if (!$mediaLink->save()) {
                        $fails++;
                    }


                } else {
                    $fails++;
                }

            }
        }

        return response()->json(['success' => $fails < 1 ? true : false]);
    }


    public function delete($request, $files)
    {
        dd($files);
        //$file = Media::where("reference", '=')
    }


    public function describe($request, $description)
    {
        //$file = Media::where("")
    }

    public function title($request, $title)
    {
        //dd($name);
    }

    public function type($request, $type)
    {
        //dd($name);
    }

}


