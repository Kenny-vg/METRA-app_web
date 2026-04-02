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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();

            $table->string('nombre_producto', 100);
            $table->string('descripcion', 255)->nullable();
            $table->string('imagen_url', 255)->nullable();
            $table->string('imagen_public_id', 255)->nullable();
            $table->decimal('precio', 10, 2)->default(0);

            $table->boolean('activo')->default(true);
            $table->integer('orden')->default(0);

            $table->foreignId('cafe_id')
                ->constrained('cafeterias')
                ->cascadeOnDelete();

            $table->foreignId('categoria_id')
                ->constrained('menu_categorias')
                ->cascadeOnDelete();

            $table->index(['categoria_id', 'activo', 'orden']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
