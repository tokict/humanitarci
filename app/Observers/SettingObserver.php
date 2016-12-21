<?php

namespace App\Observers;

use App\Models\ActionLog;
use App\Models\Setting;


class SettingObserver
{


    /**
     * Listen to the Setting update event.
     *
     * @param  Setting  $setting
     * @return void
     */
    public function updated(Setting $setting)
    {

        ActionLog::log(ActionLog::TYPE_PERSON_UPDATE, $setting->toArray());
    }



}