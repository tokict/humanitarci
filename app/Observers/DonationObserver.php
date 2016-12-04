<?php

namespace App\Observers;

use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Donor;


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
        error_log('Donation input created');
        $donor = Donor::find($donation->donor_id);

        $donor->total_donations += 1;
        $donor->amount_donated += $donation->amount;
        $donor->save();


        $campaign = Campaign::find($donation->campaign_id);
        $campaign->recalculate();
        $campaign->save();


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