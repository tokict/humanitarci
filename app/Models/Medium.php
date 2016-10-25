<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Medium
 * 
 * @property int $id
 * @property string $reference
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $modified_at
 * @property string $type
 * @property bool $is_local
 * @property string $description
 * @property string $title
 * @property int $size_id
 * 
 * @property \Illuminate\Database\Eloquent\Collection $campaigns
 * @property \Illuminate\Database\Eloquent\Collection $media_links
 *
 * @package App\Models
 */
class Medium extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'is_local' => 'bool',
		'size_id' => 'int'
	];

	protected $dates = [
		'modified_at'
	];

	protected $fillable = [
		'reference',
		'modified_at',
		'type',
		'is_local',
		'description',
		'title',
		'size_id'
	];

	public function campaigns()
	{
		return $this->hasMany(\App\Models\Campaign::class, 'cover_photo_id');
	}

	public function media_links()
	{
		return $this->hasMany(\App\Models\MediaLink::class, 'media_id');
	}
}
