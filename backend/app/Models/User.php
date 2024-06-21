<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    public const TABLE = 'users';
    public const PRIMARY_KEY = 'id';
    public const NAME = 'name';
    public const EMAIL = 'email';
    public const PASSWORD = 'password';
    public const PHONE_NUMBER = 'phone_number';
    public const REMEMBER_TOKEN = 'remember_token';
    public const EMAIL_VERIFIED_AT = 'email_verified_at';

    protected $table = self::TABLE;
    protected $primaryKey = self::PRIMARY_KEY;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::NAME,
        self::EMAIL,
        self::PHONE_NUMBER,
        self::PASSWORD,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        self::PASSWORD,
        self::REMEMBER_TOKEN,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            self::EMAIL_VERIFIED_AT => 'datetime',
            self::PASSWORD => 'hashed',
        ];
    }

    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class, Account::OWNER);
    }

    public function creditCards(): HasManyThrough
    {
        return $this->hasManyThrough(
            CreditCard::class,
            Account::class,
            Account::OWNER,
            CreditCard::ACCOUNT,
        );
    }

    protected function scopeUsersWithMostTransactionsAfter(
        Builder $builder,
        \DateTimeInterface $dateTime,
    ): Builder {
        return $builder
            ->select(self::TABLE . '.*')
            ->addSelect(DB::raw(
                join('', [
                    'count(',
                    Transaction::TABLE,
                    '.',
                    Transaction::CREATED_AT,
                    ') as transactions_count',
                ]),
            ))
            ->join(
                Account::TABLE,
                fn(JoinClause $join) => $join->on(
                    Account::OWNER,
                    self::TABLE . '.' . self::PRIMARY_KEY,
                ),
            )->join(
                CreditCard::TABLE,
                fn(JoinClause $join) => $join->on(
                    CreditCard::ACCOUNT,
                    Account::TABLE . '.' . Account::PRIMARY_KEY,
                ),
            )->join(
                Transaction::TABLE,
                fn(JoinClause $join) => $join
                    ->on(
                        Transaction::SENDER_CARD,
                        CreditCard::TABLE . '.' . Account::NUMBER,
                    )
                    ->orOn(
                        Transaction::RECEIVER_CARD,
                        CreditCard::TABLE . '.' . Account::NUMBER,
                    ),
            )->where(
                Transaction::TABLE . '.' . Transaction::CREATED_AT,
                '>=',
                $dateTime,
            )
            ->groupBy(self::TABLE . '.' . Transaction::PRIMARY_KEY)
            ->orderBy('transactions_count', 'desc');
    }
}
