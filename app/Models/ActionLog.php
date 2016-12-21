<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 25 Oct 2016 11:48:55 +0000.
 */

namespace App\Models;

use Illuminate\Support\Facades\Auth;


/**
 * Class ActionLog
 * This class handles all logging of actions on the system. It should use events to get them
 *
 * @property int $id
 *
 * @property string $type
 * Name of the action event. Needs to be one of the names provided in config
 *
 *
 * @property int $admin_id
 * If the event is initiated by admin, this is the admin id
 *
 * @property int $donor_id
 * If the event is initiated by donor, this is the donor id
 *
 * @property $item_id
 *
 *
 * @property string $data
 * Params from the event to save for archiving. Serialized array
 *
 * @property \Carbon\Carbon $created_at
 *
 * @property \App\Models\Donor $donor
 * Donor object associated with entry
 *
 * @property \App\Models\Admin $admin
 * Admin object associated with entry
 *
 * @package App\Models
 */
class ActionLog extends BaseModel
{
    const TYPE_MONETARY_INPUT = 'monetary_input';
    const TYPE_MONETARY_OUTPUT = 'monetary_output';
    const TYPE_CAMPAIGN_UPDATE = 'campaign_update';
    const TYPE_DONOR_UPDATE = 'donor_update';
    const TYPE_NOTICE = 'notice';
    const TYPE_CAMPAIGN_CREATE = 'campaign_create';
    const TYPE_DONOR_CREATE = 'donor_create';
    const TYPE_BENEFICIARY_CREATE = 'beneficiary_create';
    const TYPE_BENEFICIARY_UPDATE = 'beneficiary_update';
    const TYPE_PERSON_CREATE = 'person_create';
    const TYPE_PERSON_UPDATE = 'person_update';
    const TYPE_ENTITY_CREATE = 'entity_create';
    const TYPE_ENTITY_UPDATE = 'entity_update';
    const TYPE_ORGANIZATION_CREATE = 'organization_create';
    const TYPE_ORGANIZATION_UPDATE = 'organization_update';
    const TYPE_TRANSACTION_CREATE = 'transaction_create';
    const TYPE_GOODS_INPUT_CREATE = 'goods_input_create';
    const TYPE_GOODS_INPUT_UPDATE = 'goods_input_update';
    const TYPE_SETTING_UPDATE = 'setting_update';
    public $timestamps = false;
    protected $casts = [
        'admin_id' => 'int',
        'donor_id' => 'int',
        'item_id' => 'int'
    ];

    protected $fillable = [
        'type',
        'admin_id',
        'donor_id',
        'data',
        'item_id'
    ];

    /**
     * We auto create user but we allow it to be passed.
     * @param $type
     * @param $data
     * @param null $user
     * @param null $admin
     */
    public static function log($type, $data = [], $donor = null, $admin = null)
    {
        $params['data'] = is_array($data) ? serialize($data) : $data;
        $params['type'] = $type;
        $params['item_id'] = $data['id'];

        //If user has donor property it means its not admin so lets use that info to see what role is the user
        if (!empty(Auth::User()->donor)) {
            $params['donor_id'] = Auth::User()->donor->id;
        }
        if (!empty(Auth::User()->admin)) {
            $params['admin_id'] = Auth::User()->admin->id;
        }

        if ($donor) {
            $params['donor_id'] = $donor;
        }

        if ($admin) {
            $params['admin_id'] = $admin;
        }


        self::create($params);
    }

    public static function findOldData($type = null, $id = null, $all = null)
    {
        if (!$all) {
            //we are returning not the latest but one before because the latest is the one we are looking at now
            if ($type) {
                return self::where('item_id', $id)
                    ->where('type', $type)
                    ->orderBy('created_at', 'desc')->get()[1];
            } else {
                return self::where('item_id', $id)
                    ->orderBy('created_at', 'desc')->get()[1];
            }
        } else {
            if ($type) {
                return self::where('item_id', $id)->where('type', $type)->get();
            }else{
                return self::where('item_id', $id)
                    ->orderBy('created_at', 'desc')->get();
            }
        }

    }

    public function donor()
    {
        return $this->belongsTo(\App\Models\Donor::class);
    }

    public function admin()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'admin_id');
    }
}
