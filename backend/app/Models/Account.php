<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use HasFactory;

    public const TABLE = 'accounts';
    public const PRIMARY_KEY = 'id';
    public const NUMBER = 'number';
    public const OWNER = 'owner_id';

    protected $table = self::TABLE;
    protected $primaryKey = self::PRIMARY_KEY;

    protected $fillable = [
        self::NUMBER,
        self::OWNER,
    ];

    public function creditCards(): HasMany
    {
        return $this->hasMany(CreditCard::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, self::OWNER);
    }
}
