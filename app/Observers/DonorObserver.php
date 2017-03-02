<?php

namespace App\Observers;

use App\Models\ActionLog;
use App\Models\Campaign;
use App\Models\Donor;


class DonorObserver
{
    /**
     * Listen to the Donor created event.
     *
     * @param  Donor  $donor
     * @return void
     */
    public function created(Donor $donor)
    {
        ActionLog::log(ActionLog::TYPE_DONOR_CREATE, $donor->toArray());
    }


    /**
     * Listen to the Donation update event.
     *
     * @param  Campaign  $donor
     * @return void
     */
    public function updated(Donor $donor)
    {

        ActionLog::log(ActionLog::TYPE_DONOR_UPDATE, $donor->toArray());
    }



}