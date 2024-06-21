<?php

return [
    'channel' => [
        'default' => env('DEFAULT_SMS_CHANNEL', 'kavenegar'),
    ],
    'channels' => [
        'kavenegar' => \App\NotificationChannels\KavenegarChannel::class,
        'ghasedak' => \App\NotificationChannels\GhasedakChannel::class,
    ],
    'ghasedak' => [
        'key' => env('GHASEDAK_API_KEY'),
        'line_number' => env('GHASEDAK_LINE_NUMBER'),
    ],
    'kavenegar' => [
        'key' => env('KAVENEGAR_API_KEY'),
        'line_number' => env('KAVENEGAR_LINE_NUMBER'),
    ],
];
