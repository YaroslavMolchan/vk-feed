<?php

namespace App\Listeners;

use App\Events\NewFeed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTelegramMessage
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
     * @param  NewFeed  $event
     * @return void
     */
    public function handle(NewFeed $event)
    {
        //
    }
}
