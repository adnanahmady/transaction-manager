<?php

namespace App\NotificationChannels;

use App\Models\User;
use App\Support\Sms\SmsNotification;

class SmsChannel implements SmsChannelInterface
{
    public function send(User $notifiable, SmsNotification $notification): void
    {
        $class = config('sms.channel.default');

        /** @var SmsChannelInterface $channel */
        $channel = new $class();

        $channel->send($notifiable, $notification);
    }
}
