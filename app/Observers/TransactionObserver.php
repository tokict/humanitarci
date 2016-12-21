<?php

namespace App\Observers;

use App\Models\ActionLog;
use App\Models\Campaign;
use App\Models\Transaction;


class TransactionObserver
{
    /**
     * Listen to the Transaction created event.
     *
     * @param  Transaction  $transaction
     * @return void
     */
    public function created(Transaction $transaction)
    {
        ActionLog::log(ActionLog::TYPE_TRANSACTION_CREATE, $transaction->toArray());
    }



    /**
     * Listen to the Transaction update event.
     *
     * @param  Campaign  $transaction
     * @return void
     */
    public function updated(Transaction $transaction)
    {

        ActionLog::log(ActionLog::TYPE_TRANSACTION_UPDATE, $transaction->toArray());
    }



}