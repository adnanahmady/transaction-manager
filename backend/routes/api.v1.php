<?php

use Illuminate\Support\Facades\Route;

Route::name('transactions.')
    ->prefix('transactions')
    ->group(base_path('routes/api/v1/transactions.php'));
Route::name('users.')
    ->prefix('users')
    ->group(base_path('routes/api/v1/users.php'));
