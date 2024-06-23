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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');

            $table->unsignedBigInteger('fk_gender');
            $table->unsignedBigInteger('fk_role');
            $table->string('company_id')->unique();
            $table->string('password');
            $table->dateTime('birthdate');
            $table->boolean('suspended');
            $table->timestamps();

            $table->string('contact_number', 11);

            $table->foreign('fk_gender')
                ->references('id')
                ->on('genders');

            $table->foreign('fk_role')
                ->references('id')
                ->on('roles');
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')
                ->primary();

            $table->foreignId('user_id')
                ->nullable()
                ->index();

            $table->string('ip_address', 45)
                ->nullable();

            $table->text('user_agent')
                ->nullable();

            $table->longText('payload');
            $table->integer('last_activity')
                ->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
    }
};
