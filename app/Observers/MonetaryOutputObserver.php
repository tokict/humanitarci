<?php

namespace App\Observers;

use App\Models\ActionLog;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\MonetaryInput;
use App\Models\MonetaryOutput;
use App\Models\MonetaryOutputSource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


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
        //Set from which donations the money for this output originated
        $donations = $monetaryOutput->campaign->donations()->orderBy('created_at', 'asc')->get();

        //Get through donations one by one and take amount needed from each until amount is full
        $this->distributeAmount($monetaryOutput);
        ActionLog::log(ActionLog::TYPE_MONETARY_OUTPUT, $monetaryOutput->toArray());


    }

    /**
     * Create resources to track where did we take money from for this expense
     * @param MonetaryOutput $monetaryOutput
     */
    public function distributeAmount(MonetaryOutput $monetaryOutput)
    {
        $donations = $monetaryOutput->campaign->donations()->orderBy('created_at', 'asc')->get();
        //echo "There is ".$donations->count()."<br>";

        $amountNeeded = $monetaryOutput->amount;
        //echo "We need  ".$amountNeeded."<br>";
        foreach ($donations as $d) {
            //echo "Doing donation  ".$d->id."<br>";

            $freeAmount = $d->getFreeAmount();
            //echo "Free amount is ".$freeAmount."<br>";
            if ($amountNeeded <= $freeAmount) {
                //echo "We are taking all from this one <br>";
                //The donation has enough funds to cove the whole amount
                MonetaryOutputSource::create(['donation_id' => $d->id, 'amount' => $amountNeeded, 'monetary_output_id' => $monetaryOutput->id]);
                $amountNeeded -= $freeAmount;
                break; //end it all
            } else {
                //echo "We are taking ".$freeAmount." from this one<br>";
                //The donation does not have enough funds to cover the whole amount
                MonetaryOutputSource::create(['donation_id' => $d->id, 'amount' => $freeAmount, 'monetary_output_id' => $monetaryOutput->id]);
                $amountNeeded -= $freeAmount;
            }
            //echo "WE NEED ".$amountNeeded.' MORE<br>';

        }
    }



    /**
     * Listen to the MonetaryInput saving event.
     *
     * @param  MonetaryOutput $monetaryOutput
     * @return void
     */
    public function saving(MonetaryOutput $monetaryOutput)
    {
        $monetaryOutput->created_by_id = Auth::user()->id;
        //Money can be taken only if there is enough in the campaign and if the campaign has right status
        $campaign = $monetaryOutput->campaign;
        if ($campaign->current_funds - $campaign->getTakenFunds() < $monetaryOutput->amount) {
            Log::alert('User' . Auth::User()->id . ': Campaign ' . $campaign->id . ' does not have enough funds to proceed with your request!');
            session()->flash('error', 'Campaign does not have enough funds to proceed with your request!');
            return false;
        }

    }


}