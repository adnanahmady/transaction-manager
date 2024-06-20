<?php

namespace App\Traits\Enums;

trait LowercaseNameTrait
{
    public function lowerName(): string
    {
        return strtolower($this->name);
    }
}
