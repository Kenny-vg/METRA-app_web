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

            $table->dateTime('fecha_checkin')->nullable();
            $table->dateTime('fecha_checkout')->nullable();

            $table->integer('numero_personas');

            $table->enum('estado', [
                'pendiente',
                'en_curso',
                'finalizada',
                'no_show',
                'cancelada'
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

            $table->integer('duracion_min')->virtualAs('TIMESTAMPDIFF(MINUTE, hora_inicio, hora_fin)');
            
            $table->index('user_id');
            $table->index(['cafe_id', 'fecha', 'estado']);

            $table->foreignId('cancelado_por_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            
            $table->string('cancelado_por_rol', 50)->nullable();

            $table->boolean('recordatorio_dia_enviado')->default(false);
            $table->boolean('recordatorio_2h_enviado')->default(false);

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
