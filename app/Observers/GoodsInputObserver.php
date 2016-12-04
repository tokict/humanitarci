<?php

namespace App\Observers;

use App\Models\GoodsInput;



class GoodsInputObserver
{
    /**
     * Listen to the GoodsInput created event.
     *
     * @param  GoodsInput  $user
     * @return void
     */
    public function created(GoodsInput $goodsInput)
    {
        dd('Fire created event');
    }

    /**
     * Listen to the GoodsInput deleting event.
     *
     * @param  GoodsInput  $user
     * @return void
     */
    public function deleting(GoodsInput $goodsInput)
    {
        //
    }



}