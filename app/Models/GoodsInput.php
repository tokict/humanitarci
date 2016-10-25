<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class GoodsInput
 * 
 * @property int $id
 * @property int $organization_id
 * @property int $campaign_id
 * @property int $donor_id
 * @property string $goods
 * @property \Carbon\Carbon $created_at
 * 
 * @property \App\Models\Campaign $campaign
 * @property \App\Models\Donor $donor
 * @property \App\Models\Organization $organization
 * @property \Illuminate\Database\Eloquent\Collection $donations
 *
 * @package App\Models
 */
class GoodsInput extends Eloquent
{
	protected $table = 'goods_input';
	public $timestamps = false;

	protected $casts = [
		'organization_id' => 'int',
		'campaign_id' => 'int',
		'donor_id' => 'int'
	];

	protected $fillable = [
		'organization_id',
		'campaign_id',
		'donor_id',
		'goods'
	];

	public function campaign()
	{
		return $this->belongsTo(\App\Models\Campaign::class);
	}

	public function donor()
	{
		return $this->belongsTo(\App\Models\Donor::class);
	}

	public function organization()
	{
		return $this->belongsTo(\App\Models\Organization::class);
	}

	public function donations()
	{
		return $this->hasMany(\App\Models\Donation::class, 'goods_received_id');
	}
}
