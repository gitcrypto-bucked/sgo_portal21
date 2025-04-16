<?php

namespace App\Listeners;

use App\Events\NewsPublished;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewsPublished
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewsPublished $event): void
    {
        $news = $event->news;
        $notification = new  \App\Http\Controllers\NotificationController();
        $notification->addNewNotification('nova noticia','news');
        unset($notification);
    }
}
