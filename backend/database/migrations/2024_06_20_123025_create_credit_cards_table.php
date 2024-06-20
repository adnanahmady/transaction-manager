<?php

use App\Models\Account;
use App\Models\CreditCard;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /** Run the migrations. */
    public function up(): void
    {
        Schema::create(CreditCard::TABLE, function (Blueprint $table): void {
            $table->id(CreditCard::PRIMARY_KEY);
            $table->string(CreditCard::NUMBER)->index();
            $table->date(CreditCard::EXPIRE_DATE);
            $table->foreignId(CreditCard::ACCOUNT)
                ->constrained(Account::TABLE, Account::PRIMARY_KEY)
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->timestamps();
        });
    }

    /** Reverse the migrations. */
    public function down(): void
    {
        Schema::table(CreditCard::TABLE, function (Blueprint $table): void {
            $table->dropForeign([CreditCard::ACCOUNT]);
        });
        Schema::dropIfExists(CreditCard::TABLE);
    }
};
