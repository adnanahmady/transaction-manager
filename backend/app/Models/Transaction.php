<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use App\Exceptions\ForbiddenToSetFeeException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;

class Transaction extends Model
{
    use HasFactory;

    public const TABLE = 'transactions';
    public const PRIMARY_KEY = 'id';
    public const SENDER_CARD = 'sender_card_number';
    public const RECEIVER_CARD = 'receiver_card_number';
    public const AMOUNT = 'amount';
    public const STATUS = 'status';
    public const FEE = 'fee';

    protected $table = self::TABLE;
    protected $primaryKey = self::PRIMARY_KEY;

    protected $fillable = [
        self::SENDER_CARD,
        self::RECEIVER_CARD,
        self::AMOUNT,
        self::STATUS,
        self::FEE,
    ];

    protected function setFeeAttribute(mixed $value): void
    {
        throw new ForbiddenToSetFeeException();
    }

    protected function setAmountAttribute(int $amount): void
    {
        $fee = config('transactions.fee');

        $this->attributes[self::AMOUNT] = $amount - $fee;
        $this->attributes[self::FEE] = $fee;
    }

    protected function getStatusAttribute(): TransactionStatus
    {
        return TransactionStatus::from($this->attributes[self::STATUS]);
    }

    public function setSender(string $number): void
    {
        $this->{self::SENDER_CARD} = $number;
    }

    public function setReceiver(string $number): void
    {
        $this->{self::RECEIVER_CARD} = $number;
    }

    public function setAmount(int $amount): void
    {
        $this->{self::AMOUNT} = $amount;
    }

    public function markAsSuccess(): void
    {
        $this->{self::STATUS} = TransactionStatus::SUCCESS->value;
    }

    public function markAsRejected(): void
    {
        $this->{self::STATUS} = TransactionStatus::REJECTED->value;
    }

    protected function scopeLastTenTransactions(
        Builder $builder,
        User $user,
        \DateTimeInterface $dateTime,
    ): Builder {
        return $builder
            ->select(self::TABLE . '.*')
            ->join(
                CreditCard::TABLE,
                fn(JoinClause $join) => $join
                    ->on(
                        Transaction::SENDER_CARD,
                        CreditCard::TABLE . '.' . Account::NUMBER,
                    )
                    ->orOn(
                        Transaction::RECEIVER_CARD,
                        CreditCard::TABLE . '.' . Account::NUMBER,
                    ),
            )->join(
                Account::TABLE,
                fn(JoinClause $join) => $join->on(
                    CreditCard::ACCOUNT,
                    Account::TABLE . '.' . Account::PRIMARY_KEY,
                ),
            )
            ->join(
                User::TABLE,
                fn(JoinClause $join) => $join->on(
                    Account::OWNER,
                    User::TABLE . '.' . User::PRIMARY_KEY,
                ),
            )->where(
                Transaction::TABLE . '.' . Transaction::CREATED_AT,
                '>=',
                $dateTime,
            )
            ->where(User::TABLE . '.' . User::PRIMARY_KEY, $user->getKey())
            ->limit(10);
    }

    public function findSender(): ?User
    {
        $creditCard = CreditCard::where(
            'number',
            $this->{self::SENDER_CARD},
        )->first();

        if (!$creditCard) {
            return null;
        }

        return $creditCard->account->owner;
    }

    public function findReceiver(): ?User
    {
        $creditCard = CreditCard::where(
            'number',
            $this->{self::RECEIVER_CARD},
        )->first();

        if (!$creditCard) {
            return null;
        }

        return $creditCard->account->owner;
    }
}
