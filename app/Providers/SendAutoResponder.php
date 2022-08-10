<?php

namespace App\Providers;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\MessageReceived;
use App\Providers\MessageWasReceived;

class SendAutoResponder implements ShouldQueue
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
     * @param  MessageWasReceived  $event
     * @return void
     */
    public function handle(MessageWasReceived $event){

        $message = $event->message;
        // if (auth()->check()){
        //     $message->email = auth()->user()->email;
        // }

        Mail::to($message->email)->send(new MessageReceived($message));
    }
}
