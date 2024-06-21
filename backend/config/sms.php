<?php

return [
    'channel' => [
        'default' => env('DEFAULT_SMS_CHANNEL', 'kavenegar'),
    ],
    'channels' => [
        'kavenegar' => \App\NotificationChannels\KavenegarChannel::class,
    ],
    'kavenegar' => [
        'key' => env('KAVENEGAR_API_KEY'),
        'line_number' => env('KAVENEGAR_API_NUMBER'),
    ],
];
