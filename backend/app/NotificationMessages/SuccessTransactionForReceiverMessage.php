<?php

namespace App\NotificationMessages;

use App\Models\User;

class SuccessTransactionForReceiverMessage implements
    NotificationMessage
{
    public function __construct(private readonly User $user) {}

    public function prepare(): string
    {
        return join(PHP_EOL, [
            'Dear ' . $this->user->name,
            'A transaction has been received for you.',
        ]);
    }
}
