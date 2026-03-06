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

            $table->tinyInteger('numero_mesa');
            $table->tinyInteger('capacidad');

            $table->string('ubicacion');
            $table->boolean('activo')->default(true);

            $table->foreignId('zona_id')
                    ->constrained('zonas')
                    ->cascadeOnDelete();
            
            $table->foreignId('cafe_id')
                    ->constrained('cafeterias')
                    ->cascadeOnDelete();

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
