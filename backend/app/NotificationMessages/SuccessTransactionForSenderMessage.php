<?php

namespace App\NotificationMessages;

use App\Models\User;

class SuccessTransactionForSenderMessage implements
    NotificationMessage
{
    public function __construct(private readonly User $user) {}

    public function prepare(): string
    {
        return join(PHP_EOL, [
            'Dear ' . $this->user->name,
            'Your transaction was successful',
        ]);
    }
}
