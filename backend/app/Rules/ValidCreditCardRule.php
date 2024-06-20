<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ValidCreditCardRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): PotentiallyTranslatedString $fail
     * @param string                                        $attribute
     * @param mixed                                         $value
     */
    public function validate(
        string $attribute,
        mixed $value,
        Closure $fail,
    ): void {
        if (!preg_match($this->validCardRule(), $value)) {
            $fail(__('Credit card number is invalid'));
        }
    }

    public function validCardRule(): string
    {
        return '/^(' . $this->validNumbers() . '){1}\d{2}-\d{4}-\d{4}$/';
    }

    public function validNumbers(): string
    {
        return str_replace(
            '-',
            '\\-',
            join('|', config('transactions.cards.valid')),
        );
    }
}
