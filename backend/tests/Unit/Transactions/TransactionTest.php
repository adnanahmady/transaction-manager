<?php

namespace Tests\Unit\Transactions;

use App\Exceptions\ForbiddenToSetFeeException;
use App\Models\Transaction;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    public function test_the_fee_can_not_get_set_manually_by_the_client_code(): void
    {
        // Assert
        $this->withoutExceptionHandling();
        $this->expectException(ForbiddenToSetFeeException::class);

        // Arrange
        $transaction = new Transaction();

        // Act
        $transaction->fee = 500;
    }
}
