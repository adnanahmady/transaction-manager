<?php

namespace App\NotificationChannels;

use App\Models\User;
use App\Support\Sms\SmsNotification;

interface SmsChannelInterface
{
    public function send(User $notifiable, SmsNotification $notification): void;
}
