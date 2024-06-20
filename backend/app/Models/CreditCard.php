<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    use HasFactory;

    public const TABLE = 'credit_cards';
    public const PRIMARY_KEY = 'id';
    public const NUMBER = 'number';
    public const EXPIRE_DATE = 'expire_date';
    public const ACCOUNT = 'account_id';

    protected $table = self::TABLE;
    protected $primaryKey = self::PRIMARY_KEY;

    protected $fillable = [
        self::NUMBER,
        self::EXPIRE_DATE,
        self::ACCOUNT,
    ];

    public function scopeFindByNumber(): void {}
}
