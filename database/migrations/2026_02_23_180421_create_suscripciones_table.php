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
        Schema::create('suscripciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cafe_id')->constrained('cafeterias');
            $table->foreignId('plan_id')->constrained('planes');

            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');

            $table->enum('estado_pago', [
                'pendiente',
                'pagado',
                'vencido',
                'cancelado'
            ]);

            $table->decimal('monto',10,2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suscripciones');
    }
};
