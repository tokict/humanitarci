<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\Beneficiary;
use App\Models\City;
use App\Models\Group;
use App\Models\LegalEntity;
use App\Models\Media;
use App\Models\MediaLink;
use App\Models\Organization;
use App\Models\Person;


use App\Http\Requests;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class SettingsController extends Controller
{
    use \App\Traits\ControllerIndexTrait;

    public function all($request)
    {




        if (Request::isMethod('post')) {
            $this->validate($request, [
                'payment_provider_tax' => 'required|numeric|max:2',
                'payment_bank_tax' => 'required|numeric|max:5',
                'payment_platform_tax' => 'required|numeric|max:3',

            ]);

            $input = Input::all();
            unset($input['_token']);

            foreach($input as $key => $value){
                $setting = Setting::whereKey($key)->get()->first();
                if($setting){
                    $setting->value = $value;
                    $setting->save();
                }else{
                    $setting = Setting::create(['key' => $key, 'value' => $value]);
                }
            }
        }

        $set = Setting::all();
        $settings = new \stdClass();
        foreach ($set as $s) {
            $settings->{$s->key} = $s->value;
        }


        return view('admin.settings.all', ['settings' => $settings]);
    }


}


