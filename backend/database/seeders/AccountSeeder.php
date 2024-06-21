<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /** Run the database seeds. */
    public function run(): void
    {
        User::all()->map(
            fn(User $user) => Account::factory()->owner($user)->create(),
        );
    }
}
