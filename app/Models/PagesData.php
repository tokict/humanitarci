<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;


/**
 * Class PageData
 * This class is used for logging visitor interactions with frontend
 * 
 * @property int $id
 * @property int $page_id
 * @property string $page_type
 * @property int $views
 * @property int $shares
 *
 * @package App\Models
 */
class PagesData extends BaseModel
{
	public $timestamps = false;
    protected $table = 'pages_data';

    protected $casts = [
        'page_id' => 'int'
    ];

	protected $fillable = [
		'page_id',
		'page_type',
		'views',
		'shares'
	];


}
