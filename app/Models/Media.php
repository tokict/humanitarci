<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use League\Flysystem\File;


/**
 * Class Media
 * All the media used on site
 *
 * @property int $id
 * @property string path
 * Unique identifier for url
 *
 * @property int $created_by
 *
 * @property \App\Models\User creator
 *
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $modified_at
 * @property string $type
 * Image, video, etc
 *
 *
 * @property string $description
 * @property string $title
 *
 *
 * @property \Illuminate\Database\Eloquent\Collection $campaigns
 * @property \Illuminate\Database\Eloquent\Collection $media_links
 *
 * @package App\Models
 */
class Media extends BaseModel
{
    public $timestamps = false;

    protected $casts = [
        'created_by' => 'bool',
    ];

    protected $dates = [
        'modified_at'
    ];

    protected $fillable = [
        'path',
        'modified_at',
        'type',
        'description',
        'title',
        'created_by'
    ];


    public function campaigns()
    {
        return $this->hasMany(\App\Models\Campaign::class, 'cover_photo_id');
    }

    public function media_links()
    {
        return $this->hasMany(\App\Models\MediaLink::class, 'media_id');
    }

    public function saveFile($file, $category, $permission)
    {
        $s3 = \Storage::disk('s3');
        $filename = $category . '/' . time() . "." . $file->getClientOriginalExtension();
        if ($s3->put($filename, file_get_contents($file->getPathname()), $permission)) {

            return $filename;
        } else {
            return false;
        }

    }

    public function getPath()
    {
        return 'https://s3.eu-central-1.amazonaws.com/humanitarci/'.$this->getAtt('path');
    }
}
