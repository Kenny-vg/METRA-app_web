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
        Schema::create('cafeterias', function (Blueprint $table) {
            $table->id(); // id estándar laravel

            $table->string('nombre');
            $table->string('descripcion')->nullable();

            $table->string('calle')->nullable();
            $table->string('num_exterior')->nullable();
            $table->string('num_interior')->nullable();
            $table->string('colonia')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('estado_republica')->nullable();
            $table->string('cp')->nullable();

            $table->string('telefono')->nullable();

            $table->enum('estado', [
                'activa',
                'suspendida',
                'pendiente'
            ])->default('pendiente');

            $table->string('foto_url')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cafeterias');
    }
};
