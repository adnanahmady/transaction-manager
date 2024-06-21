<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\CreditCard;
use App\Support\Fakers\CardNumberFaker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CreditCard>
 */
class CreditCardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            CreditCard::NUMBER => (new CardNumberFaker())->fake(),
            CreditCard::ACCOUNT => Account::factory(),
            CreditCard::EXPIRE_DATE => $this->faker->dateTimeBetween(
                '+ 1 month',
                '+ 5 years',
            )->format('Y-m-d'),
        ];
    }

    public function account(Account $account): static
    {
        return $this->state(fn() => [
            CreditCard::ACCOUNT => $account->getKey(),
        ]);
    }
}
