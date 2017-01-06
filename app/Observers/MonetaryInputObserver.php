<?php

namespace App\Observers;

use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Donor;
use App\Models\MonetaryInput;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class MonetaryInputObserver
{
    /**
     * Listen to the MonetaryInput created event.
     *
     * @param  MonetaryInput $monetaryInput
     * @return void
     */
    public function created(MonetaryInput $monetaryInput)
    {
        //New input, create donations if we have info
        $provider_tax = Setting::getSetting('payment_provider_tax')->value;
        $platform_tax = Setting::getSetting('payment_platform_tax')->value;
        $bank_tax = Setting::getSetting('payment_bank_tax')->value;
        $tax = $bank_tax + $platform_tax + $provider_tax;
        $donationInfo = $monetaryInput->payment_provider_datum->order->donations;
        Log::info('Monetary input created from input ' . $monetaryInput->id . ' with amount of ' . $monetaryInput->amount . ' to campaign ' . $monetaryInput->campaign_id);

        if (isset($donationInfo)) {
            foreach (unserialize($donationInfo) as $item) {

                $campaign = Campaign::find($item['campaign']);
                $donation = new Donation;
                $donation->beneficiary_id = $campaign->beneficiary_id;
                $donation->donor_id = $monetaryInput->donor_id;
                $donation->campaign_id = $campaign->id;
                $donation->type = 'money';
                $donation->status = 'received';
                $donation->source = 'site';
                $donation->amount = $item['amount'] * 100 - (($item['amount'] * 100) / 100 * $tax);
                $donation->payment_id = $monetaryInput->id;
                $donation->organization_id = $campaign->organization_id;
                $donation->save();

            }

            $donor = Donor::find($donation->donor_id);
            $donor->recalculateDiversityScore();

            $donor->total_donations += 1;
            $donor->amount_donated += $donation->amount;

            if($campaign->priority >= 4){
                $donor->critical_score = $donor->critical_score + 10;
            }

            if($campaign->status == 'succeeded'){
                $donor->closer_score = $donor->closer_score + 10;

                Mail::queue('emails.donation_thankyou_closing', ['user' => $donor->user, 'donations' => $donationInfo], function ($m) use ($donor) {

                    $m->to($donor->user->email, $donor->user->first_name)->subject('Hvala na donaciji!');
                });
            }
            else {
                Mail::queue('emails.donation_thankyou', ['user' => $donor->user, 'donations' => $donationInfo], function ($m) use ($donor) {

                    $m->to($donor->user->email, $donor->user->first_name)->subject('Hvala na donaciji!');
                });
            }
            $donor->save();
        }






    }

    /**
     * Listen to the MonetaryInput creating event.
     *
     * @param  MonetaryInput $monetaryInput
     * @return void
     */
    public function saving(MonetaryInput $monetaryInput)
    {
        $total_tax = Setting::getSetting('payment_provider_tax')->value
            + Setting::getSetting('payment_platform_tax')->value
            + Setting::getSetting('payment_bank_tax')->value;

        $monetaryInput->amount = $monetaryInput->amount * 100 - (($monetaryInput->amount * 100) / 100 * $total_tax);
    }


}