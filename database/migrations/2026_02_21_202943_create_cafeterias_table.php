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
        Schema::create('cafeterias', function (Blueprint $table) {
            $table->id(); // id estándar laravel

            $table->string('nombre');
            $table->string('slug')->unique();
            $table->string('descripcion')->nullable();

            $table->string('calle')->nullable();
            $table->string('num_exterior')->nullable();
            $table->string('num_interior')->nullable();
            $table->string('colonia')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('estado_republica')->nullable();
            $table->string('cp')->nullable();

            $table->string('telefono')->nullable();

            $table->integer('porcentaje_reservas')->default(50);

            $table->integer('duracion_reserva_min')->default(90);
            $table->integer('intervalo_reserva_min')->default(30);

            $table->enum('estado', [
                'activa',
                'suspendida',
                'pendiente',
                'en_revision'
            ])->default('pendiente');

            $table->string('foto_url')->nullable();

            // Gerente que registró la cafetería
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            // Comprobante de pago subido por el gerente
            $table->string('comprobante_url')->nullable();
            
            $table->index('user_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cafeterias');
    }
};
