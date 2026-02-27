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
            $table->id();

        // Datos básicos
        $table->string('name');
        $table->string('ap_paterno')->nullable();
        $table->string('ap_materno')->nullable();

        $table->string('email')->unique();
        $table->string('password');
        $table->string('google_id')->nullable();
        $table->string('avatar')->nullable();

        // Roles del sistema
        $table->enum('role', [
            'superadmin',
            'gerente',
            'personal',
            'cliente'
        ]);

        $table->boolean('estado')->default(true);

        // Multi cafetería (SaaS)
        $table->unsignedBigInteger('cafe_id')->nullable();

        $table->rememberToken();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
