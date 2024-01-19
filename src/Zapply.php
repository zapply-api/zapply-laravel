<?php

namespace Zapply\Laravel;

use Illuminate\Notifications\Notification;
use Zapply\Zapply as ZapplyClient;

class Zapply
{
    /**
     *
     * @param ZapplyClient $zapply
     * @return void
     */
    public function __construct(public ZapplyClient $zapply)
    {
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification): void
    {
        if (!$to = $notifiable->routeNotificationFor('zapply', $notification)) {
            return;
        }

        $message = $notifiable->toZapply($notifiable);

        $this->zapply->chat($to)->sendMessage($message->payload());
    }
}
