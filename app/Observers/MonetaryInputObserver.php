<?php

namespace App\Observers;

use App\Models\Campaign;
use App\Models\Donation;
use App\Models\MonetaryInput;


class MonetaryInputObserver
{
    /**
     * Listen to the MonetaryInput created event.
     *
     * @param  MonetaryInput $user
     * @return void
     */
    public function created(MonetaryInput $monetaryInput)
    {
        //New input, create donations if we have info

        $donationInfo = $monetaryInput->payment_provider_datum->order->donations;
        error_log('Monetary input created');

        if (isset($donationInfo)) {
            foreach (unserialize($donationInfo) as $item) {
                //ToDo Check if we get whole amount from provider. If not, calculate in banks fees
                if ($monetaryInput->payment_provider_datum->order->amount == $monetaryInput->amount) {
                    $campaign = Campaign::find($item['campaign']);
                    $donation = new Donation;
                    $donation->beneficiary_id = $campaign->beneficiary_id;
                    $donation->donor_id = $monetaryInput->donor_id;
                    $donation->campaign_id = $campaign->id;
                    $donation->type = 'money';
                    $donation->status = 'received';
                    $donation->source = 'site';
                    $donation->amount = $item['amount'] * 100;
                    $donation->payment_id = $monetaryInput->id;
                    $donation->organization_id = $campaign->organization_id;
                    $donation->save();


                } else {
                    //ToDo: Log error and notify admin by mail because paid sum is not equal to orders
                }
            }
        }


    }

    /**
     * Listen to the MonetaryInput deleting event.
     *
     * @param  MonetaryInput $user
     * @return void
     */
    public function deleting(MonetaryInput $monetaryInput)
    {
        //
    }


}