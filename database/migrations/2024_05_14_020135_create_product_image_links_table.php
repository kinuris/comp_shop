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
        Schema::create('product_image_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_product');
            $table->string('image_link');
            $table->timestamps();

            $table->foreign('fk_product')
                ->references('id')
                ->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_image_links');
    }
};
