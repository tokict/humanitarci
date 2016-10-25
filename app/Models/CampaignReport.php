<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CampaignReport
 * 
 * @property int $id
 * @property int $campaign_id
 * 
 * @property \App\Models\Campaign $campaign
 *
 * @package App\Models
 */
class CampaignReport extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'campaign_id' => 'int'
	];

	protected $fillable = [
		'campaign_id'
	];

	public function campaign()
	{
		return $this->belongsTo(\App\Models\Campaign::class);
	}
}
