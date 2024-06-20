<?php

namespace App\Enums;

use App\Traits\Enums\LowercaseNameTrait;

enum TransactionStatus: int
{
    use LowercaseNameTrait;

    case REJECTED = 0;
    case SUCCESS = 1;
}
