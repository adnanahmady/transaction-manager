<?php

namespace App\NotificationChannels;

use App\Models\User;
use App\Support\Sms\SmsMessageInterface;
use App\Support\Sms\SmsNotification;
use Ghasedak\GhasedakApi;

class GhasedakChannel implements SmsChannelInterface
{
    public function send(User $notifiable, SmsNotification $notification): void
    {
        /** @var SmsMessageInterface $message */
        $message = $notification->toSms($notifiable);

        (new GhasedakApi(config('sms.ghasedak.key')))
            ->SendSimple(
                $message->getReceptor(),
                $message->getContent(),
                $message->getLineNumber(),
            );
    }
}
