<?php

namespace App\Listeners;

use App\Events\SendUserRegisteredMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use Mail;
use App\Mail\UserRegistered;
// 
class SendUserRegisteredMailFired implements ShouldQueue
{
 
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SendUserRegisteredMail  $event
     * @return void
     */
    public function handle(SendUserRegisteredMail $event)
    {
        \Mail::to($event->userEmail)->send(
            new UserRegistered($event->userPassword)
        );
    }
}
