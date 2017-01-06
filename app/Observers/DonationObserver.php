<?php

namespace App\Observers;

use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Donor;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class DonationObserver
{
    /**
     * Listen to the Donation created event.
     *
     * @param  Donation  $user
     * @return void
     */
    public function created(Donation $donation)
    {

        $campaign = Campaign::find($donation->campaign_id);
        $campaign->recalculate();
        $campaign->save();


        error_log('Donation entered');









    }

    /**
     * Listen to the Donation deleting event.
     *
     * @param  Donation  $user
     * @return void
     */
    public function deleting(Donation $donation)
    {
        //
    }



}