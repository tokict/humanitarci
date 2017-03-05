<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PageViewed
{
    public $pageData;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($pageData = [])
    {
        $this->pageData = $pageData;
    }

}
