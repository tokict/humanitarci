<?php

namespace App\Observers;

use App\Models\ActionLog;
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
        ActionLog::log(ActionLog::TYPE_DONATION_CREATE, $donation->toArray());
        $campaign = Campaign::find($donation->campaign_id);
        $campaign->recalculate();
        $campaign->save();


        Log::info('Donation of '.($donation->amount/100).' from donor id '.$donation->donor_id.' for campaign '.$donation->campaign_id.' entered and campaign recalculated');









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