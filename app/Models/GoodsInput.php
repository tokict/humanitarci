<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class GoodsInput
 * Goods input are all the physical things we received for the platforms beneficiaries. We make donations from this
 * 
 * @property int $id
 * @property int $organization_id
 * Id of organization that got the input
 *
 * @property int $campaign_id
 * Campaign Id this input was meant for
 *
 * @property int $donor_id
 * Who is the donor who donated it
 *
 * @property string $goods
 * Serialized array of goods that are a part of this donation with quntities (From goods table)
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
