<?php

namespace App\Observers;

use App\Models\ActionLog;
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
        #New input, create donations if we have info

        $amount = $monetaryInput->amount;
        $provider_tax = Setting::getSetting('payment_provider_tax')->value;
        $platform_tax = Setting::getSetting('payment_platform_tax')->value;
        $bank_tax = Setting::getSetting('payment_bank_tax')->value;
        $remaining = $amount;
        $donationInfo = isset($monetaryInput->payment_provider_datum)
            ? $monetaryInput->payment_provider_datum->order->donations :
            $monetaryInput->bank_transfers_datum->order->donations;
        Log::info('Monetary input created from input ' . $monetaryInput->id
            . ' with amount of ' . $monetaryInput->amount . ' to campaign ' . $monetaryInput->campaign_id);


        $donations = [];
        if (isset($donationInfo)) {
            $order = isset($monetaryInput->payment_provider_datum) ? $monetaryInput->payment_provider_datum->order :
                $monetaryInput->bank_transfers_datum->order;
            if ($order->payment_method == 'bank_transfer') {
                $tax = $platform_tax;
                $don = unserialize($donationInfo);
                foreach ($don as $key => $item) {
                    $index = substr($monetaryInput->bank_transfers_datum->reference, -1);
                    //Check the last number on reference user put in
                    if (!is_numeric($index) || (int)$index > count($don) || $key != (int)$index || !isset($don[$index])) {
                        continue;
                    }

                    #Make it same format
                    $item['amount'] = $item['amount'] * 100;


                    $campaign = Campaign::find($item['campaign']);
                    $donation = new Donation;
                    $donation->beneficiary_id = $campaign->beneficiary_id;
                    $donation->donor_id = $monetaryInput->donor_id;
                    $donation->campaign_id = $campaign->id;
                    $donation->type = 'money';
                    $donation->status = 'received';
                    $donation->source = 'site';
                    #Applying tax here because we cannot put all in donation, only whats left after tax
                    $donation->amount = $monetaryInput->amount - (($monetaryInput->amount) / 100 * $tax);
                    $donation->payment_id = $monetaryInput->id;
                    $donation->organization_id = $campaign->organization_id;
                    if(!$donation->save()){
                        $this->error('Failed to save donation of: '.$monetaryInput->amount);
                    }
                    $remaining -= $donation->amount;

                    $donations[] = $donation;

                    $donor = Donor::find($donation->donor_id);
                    $donor->recalculateDiversityScore();

                    if ($campaign->priority >= 4) {
                        $donor->critical_score = $donor->critical_score + 10;
                    }

                    $donor->total_donations += 1;
                    $donor->amount_donated += $donation->amount;
                    $donor->save();
                }

                try {
                    Mail::queue('emails.donation_thankyou', [
                        'user' => $donor->user,
                        'donations' => $donations,
                        'donation' => $donation,
                        'amount' => $amount
                    ], function ($m) use ($donor) {

                        $m->to($donor->user->email, $donor->user->first_name)->subject('Hvala na donaciji!');
                    });

                } catch (\Exception $e) {
                    Log::error('Could not send mail for donation: ' . ' on line ' . $e->getMessage() . ' on line ' . $e->getLine() . ' file ' . $e->getFile());
                }

            } else {
                $tax = $bank_tax + $platform_tax + $provider_tax;
                $don = unserialize($donationInfo);

                foreach ($don as $key => $item) {
                    #Make it same format
                    $item['amount'] = $item['amount'] * 100;

                    #If there is no more cash, just skip all
                    if ($remaining == 0) {
                        continue;
                    }

                    #If the amount remaining is less than donation, assign it all to this donation
                    #Donation can have less than in orderhome
                    if ($item['amount'] <= $remaining) {
                        $item['amount'] = $remaining;
                    }

                    #If its the last donation, assign everything left to it. All extra paid goes to last and
                    # last can get less money than in order
                    if (count($don) == $key - 1) {
                        $item['amount'] = $remaining;
                    }

                    #If there is enough cash, just proceed below


                    $campaign = Campaign::find($item['campaign']);
                    $donation = new Donation;
                    $donation->beneficiary_id = $campaign->beneficiary_id;
                    $donation->donor_id = $monetaryInput->donor_id;
                    $donation->campaign_id = $campaign->id;
                    $donation->type = 'money';
                    $donation->status = 'received';
                    $donation->source = 'site';
                    #Applying tax here because we cannot put all in donation, only whats left after tax
                    $donation->amount = $remaining - (($remaining) / 100 * $tax);
                    $donation->payment_id = $monetaryInput->id;
                    $donation->organization_id = $campaign->organization_id;
                    $donation->save();
                    $remaining -= $donation->amount;

                    $donations[] = $donation;

                    $donor = Donor::find($donation->donor_id);
                    $donor->recalculateDiversityScore();

                    if ($campaign->priority >= 4) {
                        $donor->critical_score = $donor->critical_score + 10;
                    }

                    $donor->total_donations += 1;
                    $donor->amount_donated += $donation->amount;
                    $donor->save();
                }

                try {
                    Mail::queue('emails.donation_thankyou', [
                        'user' => $donor->user,
                        'donations' => $donations,
                        'donation' => $donation,
                        'amount' => $amount
                    ], function ($m) use ($donor) {

                        $m->to($donor->user->email, $donor->user->first_name)->subject('Hvala na donaciji!');
                    });
                } catch (\Exception $e) {
                    Log::error('Could not send mail for donation: ' . ' on line ' . $e->getMessage() . ' on line ' . $e->getLine() . ' file ' . $e->getFile());
                }

            }
        }

        ActionLog::log(ActionLog::TYPE_MONETARY_INPUT, $monetaryInput->toArray());
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

        if (isset($monetaryInput->bank_transfer_data_id)) {
            $monetaryInput->amount = number_format($monetaryInput->amount
                - (($monetaryInput->amount) / 100 * $total_tax), 0, '.', '');
        } else {
            $monetaryInput->amount = number_format($monetaryInput->amount * 100
                - (($monetaryInput->amount * 100) / 100 * $total_tax), 0, '.', '');
        }

    }

    function findClosest($needle, array $haystack)
    {

        sort($haystack);

        $b = 0; // bottom
        $u = count($haystack) - 1; // up

        while ($u - $b > 1) {
            $m = round(($b + $u) / 2);
            if ($haystack[$m] < $needle) $b = $m;
            else $u = $m;
        }

        $x = $haystack[$b];
        $y = $haystack[$u];
        return (($needle - $x) > ($y - $needle)) ? $y : $x;

    }


}