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
        Schema::create('product_restocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_product');
            $table->unsignedBigInteger('fk_user');
            $table->integer('amount');

            $table->timestamps();

            $table->foreign('fk_product')
                ->references('id')
                ->on('products');

            $table->foreign('fk_user')
                ->references('user_id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_restocks');
    }
};
