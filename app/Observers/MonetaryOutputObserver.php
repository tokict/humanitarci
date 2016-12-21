<?php

namespace App\Observers;

use App\Models\Campaign;
use App\Models\Donation;
use App\Models\MonetaryInput;
use App\Models\MonetaryOutput;


class MonetaryOutputObserver
{
    /**
     * Listen to the MonetaryInput created event.
     *
     * @param  MonetaryOutput $monetaryOutput
     * @return void
     */
    public function created(MonetaryOutput $monetaryOutput)
    {
        //New input, create donations if we have info

        \Log::info('Monetary output created');




    }

    /**
     * Listen to the MonetaryInput saving event.
     *
     * @param  MonetaryOutput $monetaryOutput
     * @return void
     */
    public function saving(MonetaryOutput $monetaryOutput)
    {
        //Money can be taken only if there is enough in the campaign and if the campaign has right status
        $campaign = $monetaryOutput->campaign;
        if($campaign ->current_funds - $campaign->getTakenFunds() < $monetaryOutput->amount){
            Log::alert('User'.Auth::User()->id.': Campaign '.$campaign->id.' does not have enough funds to proceed with your request!');
            session()->flash('error', 'Campaign does not have enough funds to proceed with your request!');
            return false;
        }
    }


}