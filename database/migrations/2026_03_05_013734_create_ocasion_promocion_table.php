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
        Schema::create('ocasion_promocion', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ocasion_id')
                    ->constrained('ocasion_especials')
                    ->cascadeOnDelete();

            $table->foreignId('promocion_id')
                    ->constrained('promocions')
                    ->cascadeOnDelete();

            $table->unique(['ocasion_id', 'promocion_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ocasion_promocion');
    }
};
