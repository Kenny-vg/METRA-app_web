<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agrega la columna en_revision a suscripciones.
     * Cuando un gerente sube un comprobante de renovación, se marca
     * en_revision=true para que el Superadmin sepa que hay algo que revisar.
     * Al aprobar o rechazar, se resetea a false.
     */
    public function up(): void
    {
        Schema::table('suscripciones', function (Blueprint $table) {
            $table->boolean('en_revision')->default(false)->after('fecha_validacion');
        });
    }

    public function down(): void
    {
        Schema::table('suscripciones', function (Blueprint $table) {
            $table->dropColumn('en_revision');
        });
    }
};
