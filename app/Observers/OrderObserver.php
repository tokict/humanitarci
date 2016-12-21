<?php

namespace App\Observers;

use App\Models\ActionLog;
use App\Models\LegalEntity;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class OrderObserver
{
    /**
     * Listen to the LegalEntity created event.
     *
     * @param  Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        ActionLog::log(ActionLog::TYPE_ENTITY_CREATE, $order->toArray());
    }


    /**
     * Listen to the LegalEntity update event.
     *
     * @param  LegalEntity  $entity
     * @return void
     */
    public function updated(Order $order)
    {

        ActionLog::log(ActionLog::TYPE_ENTITY_UPDATE, $order->toArray());
    }

    /**
     * Listen to the LegalEntity creating event.
     *
     * @param  LegalEntity  $entity
     * @return void
     */
    public function creating(Order $order)
    {

    }



}