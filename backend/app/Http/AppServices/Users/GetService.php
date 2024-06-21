<?php

namespace App\Http\AppServices\Users;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Collection;

class GetService
{
    public function getWithHighestTransactions(): Collection
    {
        $users = User::query()
            ->usersWithMostTransactionsAfter(now()->subMinutes(10))
            ->limit(3)
            ->get();

        return $users->map(
            function ($u) {
                $u->transactions = Transaction::query()
                    ->lastTenTransactions($u, now()->subMinutes(10))
                    ->get();

                return $u;
            },
        );
    }
}
