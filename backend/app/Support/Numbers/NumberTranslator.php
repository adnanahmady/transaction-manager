<?php

namespace App\Support\Numbers;

class NumberTranslator
{
    private array $persianNumbers = [
        '۱',
        '۲',
        '۳',
        '۴',
        '۵',
        '۶',
        '۷',
        '۸',
        '۹',
        '۰',
    ];

    private array $englishNumbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0];

    public function translate(string $text): string
    {
        return str_replace($this->persianNumbers, $this->englishNumbers, $text);
    }
}
