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
        Schema::create('mesas', function (Blueprint $table) {
            $table->id();

        $table->integer('numero_mesa');
        $table->integer('capacidad');

        // disponible | ocupada | reservada
        $table->string('estado')->default('disponible');

        $table->string('ubicacion')->nullable();

        //relación cafetería
        $table->unsignedBigInteger('cafe_id');

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mesas');
    }
};
