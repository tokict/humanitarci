<?php

namespace App\Listeners;

use App\Events\PageViewed;
use App\Models\PageData;
use App\Models\PagesData;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PageView
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PageViewed  $event
     * @return void
     */
    public function handle(PageViewed $event)
    {

        $pageData = PagesData::where('page_id', $event->pageData['id'])->where('page_type', $event->pageData['type'])->get()->first();
        if($pageData){
            $pageData->views = $pageData->views + 1;
            $pageData->save();
        }else{
            PagesData::create([
                'page_id' => $event->pageData['id'],
                'page_type' => $event->pageData['type'],
                'views' => 1
            ]);
        }

    }
}
