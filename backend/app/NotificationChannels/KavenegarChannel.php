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

        $sms = (new KavenegarApi(config('sms.kavenegar.key')))
            ->send(
                $message->getLineNumber(),
                $message->getReceptor(),
                $message->getContent(),
            );

        if ($sms->result->code === 200) {
            $notifiable->notificationMessaged($notification->id);
        }
    }
}
