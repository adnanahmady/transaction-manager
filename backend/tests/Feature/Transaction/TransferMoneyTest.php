<?php

namespace Tests\Feature\Transaction;

use App\Enums\TransactionStatus;
use App\Models\Transaction;
use App\Support\Numbers\NumberTranslator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class TransferMoneyTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_response_data_should_be_as_expected(): void
    {
        $data = [
            'sender_card_number' => '6274-1234-6655-4786',
            'receiver_card_number' => '6274-1234-6655-4785',
            'amount' => 20_000,
        ];

        $response = $this->postJson(
            uri: route('api.v1.transactions.transfer'),
            data: $data,
        );

        $response->assertJson(
            fn(AssertableJson $json) => $json
                ->has('data.id')
                ->has('data.sender_card_number')
                ->has('data.receiver_card_number')
                ->has('data.amount')
                ->has('data.fee')
                ->where('data.status', TransactionStatus::SUCCESS->lowerName())
                ->has('data.created_at'),
        );
        $this->assertDateTime($response->json('data.created_at'));
    }

    public function test_persian_numbers_should_translate_to_english_once(): void
    {
        $data = [
            'sender_card_number' => '6274-1234-66۸7-4786',
            'receiver_card_number' => '6274-1234-6۷55-۳443',
            'amount' => '۲۶۹۳۳۹۹۰',
        ];
        $amount = (int) (new NumberTranslator())->translate($data['amount']);

        $response = $this->postJson(
            uri: route('api.v1.transactions.transfer'),
            data: $data,
        );

        $response->assertCreated();
        $this->assertDatabaseHas(Transaction::class, [
            'amount' => $amount - config('transactions.fee'),
        ]);
    }

    public function test_after_transaction_is_done_the_fee_should_get_decremented(): void
    {
        $fee = config('transactions.fee');
        $data = [
            'sender_card_number' => '6274-1234-6655-4786',
            'receiver_card_number' => '6274-1234-6655-4785',
            'amount' => 20_000,
        ];

        $this->postJson(
            uri: route('api.v1.transactions.transfer'),
            data: $data,
        );

        $this->assertDatabaseHas(Transaction::class, [
            Transaction::SENDER_CARD => $data['sender_card_number'],
            Transaction::RECEIVER_CARD => $data['receiver_card_number'],
            Transaction::AMOUNT => $data['amount'] - $fee,
            Transaction::FEE => $fee,
            Transaction::STATUS => TransactionStatus::SUCCESS->value,
        ]);
    }

    public static function dataProviderForDataValidation(): array
    {
        return [
            'maximum value for the "amount" should be 50 million tomans' => ['data' => [
                'sender_card_number' => '6274-1234-6655-4786',
                'receiver_card_number' => '6274-1234-6655-4785',
                'amount' => 500_000_001,
            ], 'expectedField' => 'amount'],
            'the "amount" should be at least 1000 tomans' => ['data' => [
                'sender_card_number' => '6274-1234-6655-4786',
                'receiver_card_number' => '6274-1234-6655-4785',
                'amount' => 9_999,
            ], 'expectedField' => 'amount'],
            'the "amount" is required' => ['data' => [
                'sender_card_number' => '6274-1234-6655-4786',
                'receiver_card_number' => '6274-1234-6655-4785',
            ], 'expectedField' => 'amount'],
            'the "receiver card number" should be a valid card number' => ['data' => [
                'sender_card_number' => '6274-1234-6655-4786',
                'receiver_card_number' => '1234-1234-6655-4785',
                'amount' => 20_000,
            ], 'expectedField' => 'receiver_card_number'],
            'the "receiver card number" is required' => ['data' => [
                'sender_card_number' => '6274-1234-6655-4785',
                'amount' => 20_000,
            ], 'expectedField' => 'receiver_card_number'],
            'the "sender card number" should be a valid card number' => ['data' => [
                'sender_card_number' => '1234-1234-6655-4786',
                'receiver_card_number' => '6274-1234-6655-4785',
                'amount' => 20_000,
            ], 'expectedField' => 'sender_card_number'],
            'the "sender card number" is required' => ['data' => [
                'receiver_card_number' => '6274-1234-6655-4785',
                'amount' => 20_000,
            ], 'expectedField' => 'sender_card_number'],
        ];
    }

    #[DataProvider('dataProviderForDataValidation')]
    public function test_data_validation(array $data, string $expectedField): void
    {
        $response = $this->postJson(
            uri: route('api.v1.transactions.transfer'),
            data: $data,
        );

        $response->assertUnprocessable();
        $response->assertJsonCount(1, 'errors');
        $response->assertJsonValidationErrorFor($expectedField);
    }

    public function test_it_should_response_with_created_status(): void
    {
        $data = [
            'sender_card_number' => '6274-1234-6655-4786',
            'receiver_card_number' => '6274-1234-6655-4785',
            'amount' => 200_000,
        ];

        $response = $this->postJson(
            uri: route('api.v1.transactions.transfer'),
            data: $data,
        );

        $response->assertCreated();
    }
}
