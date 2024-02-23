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
            $table->foreignId('type_transaction_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->unsignedBigInteger('transmitter_bank_account_id');
            $table->foreign('transmitter_bank_account_id')->references('id')->on('bank_accounts');

            $table->unsignedBigInteger('receiver_bank_account_id')->nullable();
            $table->foreign('receiver_bank_account_id')->references('id')->on('bank_accounts');
            
            $table->float('amount')->nullable();

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
