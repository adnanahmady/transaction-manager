<?php

namespace App\NotificationMessages;

interface NotificationMessage
{
    public function prepare(): string;
}
