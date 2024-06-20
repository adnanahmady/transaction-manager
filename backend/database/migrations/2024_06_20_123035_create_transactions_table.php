<?php

use App\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The sender and receiver cards do have inverted
 * relations with cards, this means that a card
 * can exist in the system, and it can get find
 * the card using the belongs to relationship.
 */
return new class () extends Migration {
    /** Run the migrations. */
    public function up(): void
    {
        Schema::create(Transaction::TABLE, function (Blueprint $table): void {
            $table->id(Transaction::PRIMARY_KEY);
            $table->string(Transaction::SENDER_CARD)->index();
            $table->string(Transaction::RECEIVER_CARD)->index();
            $table->unsignedBigInteger(Transaction::AMOUNT);
            $table->tinyInteger(Transaction::STATUS);
            $table->unsignedBigInteger(Transaction::FEE);
            $table->timestamps();
        });
    }

    /** Reverse the migrations. */
    public function down(): void
    {
        Schema::dropIfExists(Transaction::TABLE);
    }
};
