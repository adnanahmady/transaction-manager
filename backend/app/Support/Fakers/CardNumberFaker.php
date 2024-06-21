<?php

namespace App\Support\Fakers;

/**
 * This class creates a valid fake credit card number.
 */
class CardNumberFaker
{
    public function fake(): string
    {
        return join('-', [
            fake()->randomElement(
                config('transactions.cards.valid'),
            ) . $this->randomNumeric(to: 99),
            $this->randomNumeric(),
            $this->randomNumeric(),
        ]);
    }

    private function randomNumeric(int $to = 9999): string
    {
        return str_pad(
            fake()->numberBetween(0, $to),
            strlen($to),
            '0',
            STR_PAD_LEFT,
        );
    }
}
