<?php

namespace App\Listeners;

use App\Events\NewUserRegister;
use App\Mail\WelcomeEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail implements ShouldQueue
{
    use InteractsWithQueue;

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
    public function handle(NewUserRegister $event): void
    {
        Mail::to($event->email)
            ->later(now()->addMinute(), new WelcomeEmail($event->name));
    }
}
