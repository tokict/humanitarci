<?php

namespace App\Observers;

use App\Models\Campaign;




class CampaignObserver
{
    /**
     * Listen to the Campaign created event.
     *
     * @param  Campaign  $user
     * @return void
     */
    public function created(Campaign $campaign)
    {
        dd('Fire created event');
    }

    /**
     * Listen to the Donation deleting event.
     *
     * @param  Campaign  $user
     * @return void
     */
    public function deleting(Campaign $campaign)
    {
        //
    }



}