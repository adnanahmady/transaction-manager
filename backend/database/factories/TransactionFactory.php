<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Support\Fakers\CardNumberFaker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CreditCard>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cardFaker = new CardNumberFaker();

        return [
            Transaction::SENDER_CARD => $cardFaker->fake(),
            Transaction::RECEIVER_CARD => $cardFaker->fake(),
            Transaction::AMOUNT => $this->faker->numberBetween(
                10_000,
                1_000_000,
            ),
            Transaction::STATUS => $this->faker->boolean(),
        ];
    }

    public function sender(string $cardNumber): static
    {
        return $this->state(fn() => [
            Transaction::SENDER_CARD => $cardNumber,
        ]);
    }

    public function receiver(string $cardNumber): static
    {
        return $this->state(fn() => [
            Transaction::RECEIVER_CARD => $cardNumber,
        ]);
    }
}
