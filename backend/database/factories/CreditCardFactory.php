<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\CreditCard;
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
            CreditCard::NUMBER => $this->faker->randomElement([
                '2071-7733-4345-4332',
                '5022-2943-8345-4302',
            ]),
            CreditCard::ACCOUNT => Account::factory(),
            CreditCard::EXPIRE_DATE => $this->faker->dateTimeBetween(
                '+ 1 month',
                '+ 5 years',
            )->format('Y-m-d'),
        ];
    }
}
