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
 * @property string $reference
 * Unique identifier for url
 *
 * @property string $directory
 *
 * @property int $created_by
 *
 * @property \App\Usercreator
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
 * @property \Illuminate\Database\Eloquent\Collection $links
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
        'reference',
        'modified_at',
        'type',
        'description',
        'title',
        'created_by',
        'directory'
    ];


    public function campaigns()
    {
        return $this->hasMany(\App\Models\Campaign::class, 'cover_photo_id');
    }

    public function links()
    {
        return $this->hasMany(\App\Models\MediaLink::class, 'media_id');
    }

    public function creator()
    {
        return $this->belongsTo(\App\User::class, 'uploaded_by');
    }

    public function saveFile($file, $folder, $permission)
    {
        $s3 = \Storage::cloud('s3');
        $name = time() . rand(1, 9999) . "." . $file->getClientOriginalExtension();
        $this->prepareForUpload($file->getPathname(), $name);

        if ($s3->put($folder . '/original_' . $name, file_get_contents($file->getPathname()), $permission)
            && $s3->put($folder . '/thumb_' . $name, file_get_contents('/tmp/thumb_' . $name), $permission)
            && $s3->put($folder . '/small_' . $name, file_get_contents('/tmp/small_' . $name), $permission)
            && $s3->put($folder . '/medium_' . $name, file_get_contents('/tmp/medium_' . $name), $permission)
            && $s3->put($folder . '/large_' . $name, file_get_contents('/tmp/large_' . $name), $permission)
        ) {

            unlink('/tmp/thumb_' . $name);
            unlink('/tmp/small_' . $name);
            unlink('/tmp/medium_' . $name);
            unlink('/tmp/large_' . $name);
            return $name;
        } else {
            return false;
        }

    }

    private function prepareForUpload($filepath, $filename)
    {
        if (is_file($filepath)) {
            $thumb = new \Imagick(realpath($filepath));
            $thumb->stripImage();
            $thumb->resizeImage(150, 0, \Imagick::FILTER_LANCZOS, 1);
            $thumb->writeImage("/tmp/thumb_" . $filename);

            $small = new \Imagick(realpath($filepath));
            $small->stripImage();
            $small->resizeImage(300, 0, \Imagick::FILTER_LANCZOS, 1);
            $small->writeImage("/tmp/small_" . $filename);

            $medium = new \Imagick(realpath($filepath));
            $medium->stripImage();
            $medium->resizeImage(600, 0, \Imagick::FILTER_LANCZOS, 1);
            $medium->writeImage("/tmp/medium_" . $filename);

            $large = new \Imagick(realpath($filepath));
            $large->stripImage();
            $large->resizeImage(1000, 0, \Imagick::FILTER_LANCZOS, 1);
            $large->writeImage("/tmp/large_" . $filename);
        }

        return true;
    }

    public function getPath($size)
    {
        return 'https://s3.eu-central-1.amazonaws.com/humanitarci/' . $this->getAtt('directory') . "/".$this->creator->organization_id."/" . $size . "_" . $this->getAtt('reference');
    }


}
