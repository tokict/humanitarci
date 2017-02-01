<?php

namespace App\Observers;

use App\Models\ActionLog;
use App\Models\Campaign;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


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
        $user = empty(Auth::User()->id) ? 0 : Auth::User()->id;
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
            'category',
            'classification_code',
            'registration_code',
            'registration_doc_id',
            'action_plan_doc_id',
            'distribution_plan_doc_id',
            'registration_request_doc_id',
            'beneficiary_request_doc_id',
        ];


        //Disallow rollback of status rules
        $origStatus = $campaign->getOriginal()['status'];
        if ($origStatus != $campaign->status) {

            #Send mails on campaign target_reached
            if ($origStatus != 'target_reached' && $campaign->status == 'target_reached') {
                Log::info('Marking campaign ' . $campaign->id . ' as target_reached');
                try {
                    Mail::queue('emails.campaign_target_reached', [
                        'campaign' => $campaign
                    ], function ($m) use ($campaign) {
                        $mails = [];
                        foreach ($campaign->donors as $d) {
                            $name = isset($d->user->person) ? $d->user->person->first_name : $d->entity->name;
                            $email = User::where('donor_id', $d->id)->get()->first()->email;
                            $mails[] = (object)['email' => $email, 'name' => $name];
                        }

                        $m->to($mails)->subject('Akcija ' . $campaign->name . ' je prikupila traženi iznos!');


                        $when = new \DateTime('tomorrow noon');
                        $m->later($when);

                    });
                } catch (\Exception $e) {
                    Log::error('Could not send mail for campaign target reached: ' . ' on line ' . $e->getMessage().' on line '.$e->getLine().' file '.$e->getFile());
                }

            }


            #If we are setting extra amount to be donated then we send emails to all previous donors
            if (!$campaign->getOriginal()['target_amount_extra']
                && $campaign->target_amount_extra
                && (!in_array($campaign->status, ['finalized'])
                )
            ) {
                Log::info('Asking more funds for campaign ' . $campaign->id);
                try {
                    Mail::queue('emails.campaign_extra_funds', [
                        'campaign' => $campaign
                    ], function ($m) use ($campaign) {
                        $mails = [];
                        foreach ($campaign->donors as $d) {
                            $name = isset($d->user->person) ? $d->user->person->first_name : $d->entity->name;
                            $email = User::where('donor_id', $d->id)->get()->first()->email;
                            $mails[] = (object)['email' => $email, 'name' => $name];
                        }

                        $m->to($mails)->subject('Akcija ' . $campaign->name . ' je uspješno dostigla cilj!');


                        $when = new \DateTime('tomorrow noon');
                        $m->later($when);

                    });
                } catch (\Exception $e) {
                    Log::error('Could not send mail for campaign target reached: ' . ' on line ' . $e->getMessage().' on line '.$e->getLine().' file '.$e->getFile());
                }

            }


            #Send mails on campaign finalized
            if ($origStatus != 'finalized' && $campaign->status == 'finalized') {
                Log::info('Marking campaign ' . $campaign->id . ' as finalized');
                try {
                    Mail::queue('emails.campaign_finalized', [
                        'campaign' => $campaign
                    ], function ($m) use ($campaign) {
                        $mails = [];
                        foreach ($campaign->donors as $d) {
                            $name = isset($d->user->person) ? $d->user->person->first_name : $d->entity->name;
                            $email = User::where('donor_id', $d->id)->get()->first()->email;
                            $mails[] = (object)['email' => $email, 'name' => $name];
                        }

                        $m->to($mails)->subject('Sredstva akcije ' . $campaign->name . ' su uspješno dostavljena korisnicima!');


                        $when = new \DateTime('tomorrow noon');
                        $m->later($when);

                    });
                } catch (\Exception $e) {
                    Log::error('Could not send mail for campaign target reached: ' . ' on line ' . $e->getMessage().' on line '.$e->getLine().' file '.$e->getFile());
                }

            }


            #Send mails on campaign failed
            if ($origStatus != 'failed' && $campaign->status == 'failed') {
                Log::info('Marking campaign ' . $campaign->id . ' as failed');
                try {
                    Mail::queue('emails.campaign_finalized', [
                        'campaign' => $campaign
                    ], function ($m) use ($campaign) {
                        $mails = [];
                        foreach ($campaign->donors as $d) {
                            $name = isset($d->user->person) ? $d->user->person->first_name : $d->entity->name;
                            $email = User::where('donor_id', $d->id)->get()->first()->email;
                            $mails[] = (object)['email' => $email, 'name' => $name];
                        }

                        $m->to($mails)->subject('Akcija' . $campaign->name . ' nije dostigla cilj!');


                        $when = new \DateTime('tomorrow noon');
                        $m->later($when);

                    });
                } catch (\Exception $e) {
                    Log::error('Could not send mail for campaign target reached: ' . ' on line ' . $e->getMessage().' on line '.$e->getLine().' file '.$e->getFile());
                }

            }


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
                Log::alert('User: ' . $user . ': If campaign ' . $campaign->id . ' was active, the next status cannot be inactive!');
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
        unset($tableCols['beneficiary_receipt_doc_id'], $tableCols['modified_at'], $tableCols['target_amount_extra']);

        //If the status is succeeded then we can only add beneficiary_receipt_id and modified_at
        if (in_array($campaign->getOriginal()['status'], ['succeeded']) && !$campaign->target_amount_extra) {
            foreach ($campaign->getOriginal() as $key => $value) {
                if (in_array($key, $tableCols)) {
                    Log::alert('User: ' . $user . ': If campaign ' . $campaign->id . ' has succeeded, you can only add beneficiary report. No changes otherwise !');
                    session()->flash('error', 'Campaign cannot be edited after campaign end except for adding beneficiary receipt!');
                    return false;
                }
            }
        }

        //No updates to campaign are allowed after finalization
        if (in_array($campaign->getOriginal()['status'], ['failed', 'succeeded', 'finalized', 'blocked'])) {
            Log::alert('User: ' . $user . ': Campaign ' . $campaign->id . ' cannot be edited cannot be edited after campaign end!');
            session()->flash('error', 'Campaign cannot be edited cannot be edited after campaign end!');
            return false;
        }

    }


}