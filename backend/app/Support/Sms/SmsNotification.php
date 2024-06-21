<?php

namespace App\Support\Sms;

use App\Models\User;

interface SmsNotification
{
    public function toSms(User $notifiable);
}
