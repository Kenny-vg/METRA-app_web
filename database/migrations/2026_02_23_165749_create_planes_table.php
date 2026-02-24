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
        Schema::create('planes', function (Blueprint $table) {
            $table->id();

            $table->string('nombre_plan')->unique();
            $table->decimal('precio',10,2);

            $table->integer('max_reservas_mes');
            $table->integer('max_usuarios_admin');

            $table->integer('duracion_dias')->default(30);
            
            $table->text('descripcion')->nullable();

            $table->boolean('estado')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planes');
    }
};
