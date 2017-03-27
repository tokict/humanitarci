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
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class LogController extends Controller
{
    use \App\Traits\ControllerIndexTrait;

    public function listing()
    {
        $logs = [];
        if (Auth::User()->super_admin) {
            $logs = ActionLog::paginate(50);
        }


        return view('admin.log.listing', ['logs' => $logs]);
    }

    public function view($request, $id)
    {
        $log = ActionLog::whereId($id)->get()->first();

        $admin = isset($log->admin_id) ? $log->admin : null;
        $donor = isset($log->donor_id) ? $log->donor : null;
        $person = isset($admin) ? $admin->user->person : $donor->user->person;

        //Get old data for certain types
        if (strpos($log->type, '_update') !== false) {
            $old_data = ActionLog::findOldData($log, null, $log->item_id)->data;
            $newerData = unserialize($log->data);
            //Group differences
            $differences = [];
            foreach(unserialize($old_data) as $key => $value){
                if(isset($newerData[$key]) && $old_data[$key] !== $value && $key != 'modified_at' && $key != 'updated_at'){
                    $differences[$key] = ['old' => $value, 'new' => $newerData[$key]];
                }
            }



        } else {
            $old_data = null;
            $differences = [];
        }

        if ($log) {
            return view('admin.log.view', ['log' => $log, 'person' => $person, 'admin' => $admin, 'donor' => $donor, 'differences' => $differences]);
        } else {
            abort(404);
        }
    }


}


