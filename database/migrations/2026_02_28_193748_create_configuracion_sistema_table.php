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
        Schema::create('configuracion_sistema', function (Blueprint $table) {
            $table->id();

            // PAGOS
            $table->string('banco')->nullable();
            $table->string('clabe')->nullable();
            $table->string('beneficiario')->nullable();
            $table->text('instrucciones_pago')->nullable();
            
            // SOPORTE
            $table->string('email_soporte')->nullable();
            $table->string('telefono_soporte')->nullable();
            $table->string('whatsapp_soporte')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracion_sistema');
    }
};
