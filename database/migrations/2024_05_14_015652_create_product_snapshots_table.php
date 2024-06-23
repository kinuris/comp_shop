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
        Schema::create('product_snapshots', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');

            $table->unsignedBigInteger('fk_category');
            $table->unsignedBigInteger('fk_supplier');
            $table->unsignedBigInteger('fk_product');
            $table->unsignedBigInteger('fk_user');

            $table->unsignedInteger('price');
            $table->timestamps();

            $table->foreign('fk_product')
                ->references('id')
                ->on('product_snapshots');

            $table->foreign('fk_category')
                ->references('id')
                ->on('categories');

            $table->foreign('fk_supplier')
                ->references('id')
                ->on('suppliers');

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
        Schema::dropIfExists('product_snapshots');
    }
};
