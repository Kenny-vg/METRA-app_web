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
        Schema::create('detalle_ocupaciones', function (Blueprint $table) {

            $table->id();

            $table->string('comentarios', 255)->nullable();

            $table->dateTime('hora_entrada')->nullable();
            $table->dateTime('hora_salida')->nullable();

            $table->enum('estado', [
                'activa',
                'finalizada',
                'cancelada'
            ])->default('activa');

            $table->foreignId('reservacion_id')
                ->nullable()
                ->constrained('reservaciones')
                ->nullOnDelete();

            $table->foreignId('id_usuario')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('id_mesa')
                ->constrained('mesas')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_ocupaciones');
    }
};
