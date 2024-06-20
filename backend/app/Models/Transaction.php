<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use App\Exceptions\ForbiddenToSetFeeException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        $fee = config('transactions.fee');

        $this->{self::AMOUNT} = $amount - $fee;
        $this->attributes[self::FEE] = $fee;
    }

    public function markAsSuccess(): void
    {
        $this->{self::STATUS} = TransactionStatus::SUCCESS->value;
    }

    public function markAsRejected(): void
    {
        $this->{self::STATUS} = TransactionStatus::REJECTED->value;
    }
}
