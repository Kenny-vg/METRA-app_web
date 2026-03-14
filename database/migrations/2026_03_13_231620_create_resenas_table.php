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
        Schema::create('resenas', function (Blueprint $table) {

            $table->id();

            $table->foreignId('detalle_ocupacion_id')
                ->constrained('detalle_ocupaciones')
                ->cascadeOnDelete();

            $table->string('token_resena', 50)->unique();

            $table->tinyInteger('calificacion');

            $table->string('comentario', 255)->nullable();

            $table->dateTime('fecha_resena')->nullable();

            $table->enum('estado', [
                'pendiente',
                'publicada',
                'oculta'
            ])->default('pendiente');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resenas');
    }
};
