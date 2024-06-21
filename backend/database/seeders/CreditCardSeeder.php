<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\CreditCard;
use Illuminate\Database\Seeder;

class CreditCardSeeder extends Seeder
{
    /** Run the database seeds. */
    public function run(): void
    {
        $numbers = [
            "6221-0683-0971-6292",
            "6219-8636-2613-7901",
        ];
        $accounts = Account::all();

        foreach ($numbers as $index => $number) {
            CreditCard::factory()->create([
                CreditCard::ACCOUNT => $accounts[$index],
                CreditCard::NUMBER => $number,
            ]);
        }
    }
}
