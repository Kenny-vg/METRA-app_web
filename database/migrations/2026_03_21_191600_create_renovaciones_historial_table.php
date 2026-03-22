<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabla de historial de renovaciones.
     * Guarda un snapshot del estado anterior de la suscripción
     * cada vez que un gerente sube un nuevo comprobante de renovación.
     */
    public function up(): void
    {
        Schema::create('renovaciones_historial', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cafe_id')->constrained('cafeterias')->cascadeOnDelete();
            $table->foreignId('suscripcion_id')->nullable()->constrained('suscripciones')->nullOnDelete();
            $table->foreignId('plan_id')->nullable()->constrained('planes')->nullOnDelete();

            $table->decimal('monto', 10, 2)->nullable();
            $table->string('comprobante_url')->nullable();

            $table->dateTime('fecha_inicio_anterior')->nullable();
            $table->dateTime('fecha_fin_anterior')->nullable();
            $table->string('estado_pago_anterior')->nullable();

            // Fecha en que se solicitó esta renovación
            $table->timestamp('fecha_solicitud')->useCurrent();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('renovaciones_historial');
    }
};
