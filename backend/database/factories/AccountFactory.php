<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            Account::NUMBER => $this->faker->unique()->numberBetween(
                1_000_000_000_000_000,
                9_999_999_999_999_999,
            ),
            Account::OWNER => User::factory(),
        ];
    }
}
