<?php

namespace Feature\Transaction;

use App\Models\Account;
use App\Models\CreditCard;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class HighTransactionUsersTest extends TestCase
{
    public function test_user_transaction_should_contain_expected_fields(): void
    {
        $this->withoutExceptionHandling();
        $this->clear();
        $route = route('api.v1.users.transactions.highest');
        $u1 = User::factory()->create();
        $this->assignTransaction($u1, 1, 2);

        $response = $this->getJson($route);

        $response->assertJsonCount(3, 'data.0.transactions');
        $response->assertJson(
            fn(AssertableJson $json) => $json
                ->has('data.0.transactions.0.id')
                ->has('data.0.transactions.0.sender_card_number')
                ->has('data.0.transactions.0.receiver_card_number')
                ->has('data.0.transactions.0.amount')
                ->has('data.0.transactions.0.status')
                ->has('data.0.transactions.0.fee')
                ->has('data.0.transactions.0.created_at'),
        );
    }

    public function test_user_should_contain_expected_fields(): void
    {
        $this->withoutExceptionHandling();
        $route = route('api.v1.users.transactions.highest');
        $u1 = User::factory()->create();
        $this->assignTransaction($u1, 10, 2);

        $response = $this->getJson($route);

        $response->assertJson(
            fn(AssertableJson $json) => $json
                ->has('data.0.id')
                ->has('data.0.name')
                ->has('data.0.email')
                ->has('data.0.phone_nubmer')
                ->has('data.0.transactions'),
        );
    }

    public function test_last_three_users_should_return(): void
    {
        $this->clear();
        $route = route('api.v1.users.transactions.highest');
        $u1 = User::factory()->create();
        $u2 = User::factory()->create();
        $u3 = User::factory()->create();
        $u4 = User::factory()->create();
        $this->travelTo(Carbon::now()->subDay(), function () use ($u1): void {
            $this->assignTransaction($u1);
            $this->assignTransaction(User::factory()->create(), senderCount: 2);
            $this->assignTransaction(User::factory()->create(), receiverCount: 3);
            $this->assignTransaction(User::factory()->create(), senderCount: 3, receiverCount: 2);
        });
        $this->assignTransaction($u1, 10, 2);
        $this->assignTransaction($u2, 12, 4);
        $this->assignTransaction($u3, 7, 1);
        $this->assignTransaction($u4, 1, 1);

        $response = $this->getJson($route);

        $response->assertJsonCount(3, 'data');
        $response->assertJsonCount(10, 'data.0.transactions');
        $response->assertJsonCount(10, 'data.1.transactions');
        $response->assertJsonCount(8, 'data.2.transactions');
    }

    public function test_the_service_should_response_ok(): void
    {
        $route = route('api.v1.users.transactions.highest');

        $response = $this->getJson($route);

        $response->assertOk();
    }

    public function assignTransaction(
        ?User $user = null,
        int $senderCount = 1,
        int $receiverCount = 1,
    ): User {
        $user = $user ?? User::factory()->create();
        $account = Account::factory()->owner($user)->create();
        $creditCard = CreditCard::factory()->account($account)->create();
        Transaction::factory()->count($senderCount)->sender($creditCard->number)->create();
        Transaction::factory()->count($receiverCount)->receiver($creditCard->number)->create();

        return $user;
    }

    /** @return void */
    public function clear(): void
    {
        Transaction::all()->each->delete();
        CreditCard::all()->each->delete();
        Account::all()->each->delete();
        User::all()->each->delete();
    }
}
