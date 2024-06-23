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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('fk_product');
            $table->unsignedBigInteger('fk_product_snapshot');
            $table->string('fk_payment_transaction');

            // NOTE: For additional discounts applied per product.
            // This also has the limitation of only 1 discount being applied in a per product basis.
            $table->unsignedBigInteger('fk_discount')
                ->nullable();

            $table->timestamps();
            $table->foreign('fk_product_snapshot')
                ->references('id')
                ->on('product_snapshots');

            $table->foreign('fk_product')
                ->references('id')
                ->on('products');

            $table->foreign('fk_payment_transaction')
                ->references('id')
                ->on('payment_transactions');

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
        Schema::dropIfExists('carts');
    }
};
