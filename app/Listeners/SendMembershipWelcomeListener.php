<?php

namespace App\Listeners;

use App\Events\PaymentCompleted;
use App\Mail\SendMembershipWelcome;
use Illuminate\Support\Facades\Mail;

class SendMembershipWelcomeListener
{
    /**
     * Handle the event.
     */
    public function handle(PaymentCompleted $event): void
    {
        Mail::to($event->data['email'])
            ->bcc([
                'wlsfernandes@gmail.com',
                'passion2plant@gmail.com',
                'drlizrios@gmail.com',
            ])
            ->send(new SendMembershipWelcome(
                $event->data
            ));
    }
}
