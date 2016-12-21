<?php

namespace App\Observers;

use App\Models\ActionLog;
use App\Models\Campaign;
use App\Models\Person;


class PersonObserver
{
    /**
     * Listen to the Person created event.
     *
     * @param  Person  $person
     * @return void
     */
    public function created(Person $person)
    {
        ActionLog::log(ActionLog::TYPE_PERSON_CREATE, $person->toArray());
    }



    /**
     * Listen to the Person update event.
     *
     * @param  Person  $person
     * @return void
     */
    public function updated(Person $person)
    {

        ActionLog::log(ActionLog::TYPE_PERSON_UPDATE, $person->toArray());
    }



}