<?php

namespace App\Observers;

use App\Models\ActionLog;
use App\Models\Beneficiary;
use App\Models\Campaign;

class BeneficiaryObserver
{
    /**
     * Listen to the Beneficiary created event.
     *
     * @param  Beneficiary  $beneficiary
     * @return void
     */
    public function created(Beneficiary $beneficiary)
    {
        ActionLog::log(ActionLog::TYPE_BENEFICIARY_CREATE, $beneficiary->toArray());
    }



    /**
     * Listen to the Beneficiary update event.
     *
     * @param  Beneficiary  $beneficiary
     * @return void
     */
    public function updated(Beneficiary $beneficiary)
    {

        ActionLog::log(ActionLog::TYPE_BENEFICIARY_UPDATE, $beneficiary->toArray());
    }



}