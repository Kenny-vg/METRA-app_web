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
        Schema::create('reservaciones', function (Blueprint $table) {
            $table->id();

            $table->string('folio', 20)->unique();

            // Datos del cliente (para reservas sin cuenta)
            $table->string('nombre_cliente', 150);
            $table->string('telefono', 20);
            $table->string('email')->nullable();

            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin');

            $table->integer('numero_personas');

            $table->enum('estado', [
                'pendiente',
                'confirmada',
                'cancelada',
                'completada',
                'no_show'
            ])->default('pendiente');

            $table->enum('tipo', [
                'linea',
                'local'
            ])->default('linea');

            $table->string('comentarios', 255)->nullable();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('cafe_id')
                ->constrained('cafeterias')
                ->cascadeOnDelete();

            $table->foreignId('ocasion_especial_id')
                ->nullable()
                ->constrained('ocasion_especials')
                ->nullOnDelete();

            $table->foreignId('promocion_id')
                ->nullable()
                ->constrained('promocions')
                ->nullOnDelete();

            $table->foreignId('zona_id')
                ->nullable()
                ->constrained('zonas')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservaciones');
    }
};
