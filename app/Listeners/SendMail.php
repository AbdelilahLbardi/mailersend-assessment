<?php

namespace App\Listeners;

use App\Events\NewEmail;
use App\Http\Resources\MailResource;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendMail
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
     * @param  NewEmail  $event
     * @return void
     */
    public function handle($event)
    {
        \App\Jobs\SendMail::dispatch($event->mail);
    }
}
