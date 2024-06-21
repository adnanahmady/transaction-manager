<?php

namespace App\NotificationChannels;

use App\Models\User;
use App\Support\Sms\SmsMessageInterface;
use App\Support\Sms\SmsNotification;
use Kavenegar\KavenegarApi;

class KavenegarChannel implements SmsChannelInterface
{
    public function send(User $notifiable, SmsNotification $notification): void
    {
        /** @var SmsMessageInterface $message */
        $message = $notification->toSms($notifiable);

        (new KavenegarApi(config('sms.kavenegar.key')))
            ->send(
                $message->getLineNumber(),
                $message->getReceptor(),
                $message->getContent(),
            );
    }
}
