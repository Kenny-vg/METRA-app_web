<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('suscripciones', function (Blueprint $table) {
            // El gerente/dueño que realizó la suscripción
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->after('monto');
            // Fecha en que el superadmin validó el pago
            $table->dateTime('fecha_validacion')->nullable()->after('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('suscripciones', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'fecha_validacion']);
        });
    }
};
