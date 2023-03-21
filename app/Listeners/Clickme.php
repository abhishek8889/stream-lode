<?php

namespace App\Listeners;

use App\Events\SendNotifications;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class Clickme
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
     * @param  \App\Events\SendNotifications  $event
     * @return void
     */
    public function handle(SendNotifications $event)
    {
        return $event->clickme;
    }
}
