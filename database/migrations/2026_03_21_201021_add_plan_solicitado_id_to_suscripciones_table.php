<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agrega plan_solicitado_id para mantener el plan actual intacto 
     * hasta que el Superadmin apruebe la nueva solicitud de plan.
     */
    public function up(): void
    {
        Schema::table('suscripciones', function (Blueprint $table) {
            $table->unsignedBigInteger('plan_solicitado_id')->nullable()->after('plan_id');
        });
    }

    public function down(): void
    {
        Schema::table('suscripciones', function (Blueprint $table) {
            $table->dropColumn('plan_solicitado_id');
        });
    }
};
