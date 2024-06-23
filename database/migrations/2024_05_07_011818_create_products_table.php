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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('barcode', length: 12)
                ->unique();

            $table->string('image_link')->nullable(); // NOTE: This is the primary image that will be shown in thumbnails
            $table->unsignedBigInteger('fk_category');
            $table->unsignedBigInteger('fk_supplier');
            $table->unsignedInteger('stock_quantity');
            $table->unsignedInteger('price');
            $table->boolean('available');
            $table->text('description');
            $table->timestamps();

            $table->foreign('fk_category')
                ->references('id')
                ->on('categories');

            $table->foreign('fk_supplier')
                ->references('id')
                ->on('suppliers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
