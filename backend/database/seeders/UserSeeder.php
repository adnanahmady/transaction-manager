<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /** Run the database seeds. */
    public function run(): void
    {
        User::factory()->create([
            User::PHONE_NUMBER => env('FIRST_TESTING_USER', '09309616418'),
        ]);
        User::factory()->create([
            User::PHONE_NUMBER => env('SECOND_TESTING_USER', '09187701393'),
        ]);
    }
}
