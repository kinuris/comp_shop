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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->string('id')
                ->primary();

            $table->unsignedBigInteger('fk_user'); // NOTE: Person who processed the transaction
            $table->unsignedBigInteger('fk_payment_method'); // NOTE: Payment method used

            // NOTE: This is an unused field, for requirement purposes only
            $table->unsignedBigInteger('fk_discount') // NOTE: Discount applied with this method ONLY ONE DISCOUNT CAN BE APPLIED
                ->nullable();

            $table->timestamps();

            $table->foreign('fk_user')
                ->references('user_id')
                ->on('users');

            $table->foreign('fk_payment_method')
                ->references('id')
                ->on('payment_methods');

            $table->foreign('fk_discount')
                ->references('id')
                ->on('discounts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
