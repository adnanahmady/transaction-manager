<?php

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /** Run the migrations. */
    public function up(): void
    {
        Schema::create(Account::TABLE, function (Blueprint $table): void {
            $table->id(Account::PRIMARY_KEY);
            $table->string(Account::NUMBER)->unique();
            $table->foreignId(Account::OWNER)
                ->constrained(User::TABLE, User::PRIMARY_KEY)
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->timestamps();
        });
    }

    /** Reverse the migrations. */
    public function down(): void
    {
        Schema::table(Account::TABLE, function (Blueprint $table): void {
            $table->dropForeign([Account::OWNER]);
        });
        Schema::dropIfExists(Account::TABLE);
    }
};
