<?php

namespace App\Observers;

use App\Models\ActionLog;
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
        ActionLog::log(ActionLog::TYPE_GOODS_INPUT_CREATE, $goodsInput->toArray());
    }

    /**
     * Listen to the GoodsInput deleting event.
     *
     * @param  GoodsInput  $user
     * @return void
     */
    public function updated(GoodsInput $goodsInput)
    {
        ActionLog::log(ActionLog::TYPE_GOODS_INPUT_UPDATE, $goodsInput->toArray());
    }



}