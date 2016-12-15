<?php

namespace App\Observers;

use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Donor;
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
        error_log('Donation input created');
        $donor = Donor::find($donation->donor_id);

        $donor->total_donations += 1;
        $donor->amount_donated += $donation->amount;
        $donor->save();


        $campaign = Campaign::find($donation->campaign_id);
        $campaign->recalculate();
        $campaign->save();

        Mail::queue('emails.donation_thankyou', ['user' => $donor->user, 'donation' => $donation, 'campaign' => $campaign], function ($m) use ($donor) {

            $m->to($donor->user->email, $donor->user->first_name)->subject('Hvala na donaciji!');
        });


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