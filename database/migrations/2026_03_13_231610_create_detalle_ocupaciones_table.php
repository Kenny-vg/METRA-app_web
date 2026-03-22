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

            $table->integer('numero_personas');

            $table->string('nombre_cliente', 150)->nullable();
            $table->string('email')->nullable();

            $table->enum('tipo', ['reservacion', 'walkin'])->default('walkin');
            $table->string('comentarios', 255)->nullable();
            $table->string('token_resena')->nullable();

            $table->dateTime('hora_entrada')->nullable();
            $table->dateTime('hora_salida')->nullable();

            $table->enum('estado', [
                'activa',
                'finalizada',
                'cancelada',
                'no_show'
            ])->default('activa');

            $table->foreignId('reservacion_id')
                ->nullable()
                ->constrained('reservaciones')
                ->nullOnDelete();

            $table->foreignId('cafe_id')
                ->constrained('cafeterias')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('mesa_id')
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
