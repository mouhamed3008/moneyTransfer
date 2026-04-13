<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_account_id');
            $table->unsignedBigInteger('receiver_account_id');
            $table->decimal('amount', 15, 2);
            $table->string('status')->default('pending');
            $table->foreign('sender_account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('receiver_account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->string('transaction_code')->unique();
            $table->string('transaction_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
