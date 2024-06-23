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
        Schema::create('applicable_discounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_product');
            $table->unsignedBigInteger('fk_discount');

            $table->timestamps();

            $table->foreign('fk_product')
                ->references('id')
                ->on('products');

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
        Schema::dropIfExists('applicable_discounts');
    }
};
