<?php

namespace App\Observers;

use App\Models\ActionLog;
use App\Models\LegalEntity;


class EntityObserver
{
    /**
     * Listen to the LegalEntity created event.
     *
     * @param  LegalEntity  $entity
     * @return void
     */
    public function created(LegalEntity $entity)
    {
        ActionLog::log(ActionLog::TYPE_ENTITY_CREATE, $entity->toArray());
    }


    /**
     * Listen to the LegalEntity update event.
     *
     * @param  LegalEntity  $entity
     * @return void
     */
    public function updated(LegalEntity $entity)
    {

        ActionLog::log(ActionLog::TYPE_ENTITY_UPDATE, $entity->toArray());
    }



}