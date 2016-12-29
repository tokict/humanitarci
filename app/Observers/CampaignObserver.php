<?php

namespace App\Observers;

use App\Models\ActionLog;
use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class CampaignObserver
{
    /**
     * Listen to the Campaign created event.
     *
     * @param  Campaign $campaign
     * @return void
     */
    public function created(Campaign $campaign)
    {
        dd('Fire created event');
    }

    /**
     * Listen to the Campaign deleting event.
     *
     * @param  Campaign $campaign
     * @return void
     */
    public function deleting(Campaign $campaign)
    {
        ActionLog::log(ActionLog::TYPE_CAMPAIGN_CREATE, $campaign->toArray());
    }


    /**
     * Listen to the Campaign update event.
     *
     * @param  Campaign $campaign
     * @return void
     */
    public function updated(Campaign $campaign)
    {


        ActionLog::log(ActionLog::TYPE_CAMPAIGN_UPDATE, $campaign->toArray());
    }

    /**
     * Listen to the Campaign saving event.
     *
     * @param  Campaign $campaign
     * @return bool,void
     *
     */
    public function saving(Campaign $campaign)
    {
        /** NOT ALLOWED FOR UPDATE AFTER CAMPAIGN LAUNCH*/
        $user = empty(Auth::User()->id)?0:Auth::User()->id;
        $fieldsLaunch = [
            'beneficiary_id',
            'target_amount',
            'type',
            'starts',
            'created_by_id',
            'name',
            'organization_id',
            'type',
            'slug',
            'ends',
            'category',
            'classification_code',
            'registration_code',
            'registration_doc_id',
            'action_plan_doc_id',
            'distribution_plan_doc_id',
            'registration_request_doc_id',
            'beneficiary_request_doc_id',
        ];


        //Disallow rollback of status
        $origStatus = $campaign->getOriginal()['status'];
        if ($origStatus != $campaign->status) {
            if ($origStatus == 'failed' || $origStatus == 'finalized') {
                Log::alert('User: ' . $user . ': You cannot edit campaign ' . $campaign->id . ' after it is finished !');
                session()->flash('error', 'You cannot edit campaign after it is finished !');
                return false;
            }


            //From blocked we can go only to active and then only forward

            if ($origStatus == 'blocked' && $campaign->status != 'active') {
                Log::alert('User: ' . $user . ': If campaign ' . $campaign->id . ' was blocked, the next status can be only active!');
                session()->flash('error', 'If a campaign was blocked, the next status can be only active!');
                return false;
            }


            //From active it can go everywhere but inactive

            if ($origStatus == 'active' && $campaign->status == 'inactive') {
                Log::alert('User: ' . $user. ': If campaign ' . $campaign->id . ' was active, the next status cannot be inactive!');
                session()->flash('error', 'If a campaign was active, the next status cannot be inactive!');
                return false;
            }


            //From inactive it can go to active or blocked

            if ($origStatus == 'inactive' && !in_array($campaign->status, ['active', 'blocked'])) {
                Log::alert('User: ' . $user . ': If campaign ' . $campaign->id . ' was inactive, the next status can be only active or blocked!');
                session()->flash('error', 'If a campaign was inactive, the next status can be only active or blocked!');
                return false;
            }
        }


        //Prevent editing of certain fields after campaign becomes active
        if ($campaign->getOriginal()['status'] == 'active') {
            foreach ($campaign->getDirty() as $key => $value) {
                if (in_array($key, $fieldsLaunch)) {
                    Log::alert('User: ' . $user . ': Campaign ' . $campaign->id . ' field "' . $key . '" cannot be changed after campaign launch!');
                    session()->flash('error', 'Field "' . $key . '" cannot be changed after campaign launch!');
                    return false;
                }
            }
        }

        $tableCols = $campaign->getTableColumns();
        unset($tableCols['beneficiary_receipt_doc_id'], $tableCols['modified_at']);

        //If the status is succeeded then we can only add beneficiary_receipt_id and modified_at
        foreach ($campaign->getOriginal() as $key => $value) {
            if (in_array($key, $tableCols)) {
                Log::alert('User: ' . $user . ': If campaign ' . $campaign->id . ' has succeeded, you can only add beneficiary report. No changes otherwise !');
                session()->flash('error', 'Campaign cannot be edited after campaign end except for adding beneficiary receipt!');
                return false;
            }
        }

        //No updates to campaign are allowed after finalization
        if (in_array($campaign->getOriginal()['status'], ['failed', 'succeeded','finalized', 'blocked'])) {
            Log::alert('User: ' . $user . ': Campaign ' . $campaign->id . ' cannot be edited cannot be edited after campaign end!');
            session()->flash('error', 'Campaign cannot be edited cannot be edited after campaign end!');
            return false;
        }

    }


}