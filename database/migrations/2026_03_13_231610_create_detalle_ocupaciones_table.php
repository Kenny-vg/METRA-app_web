<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration 
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detalle_ocupaciones', function (Blueprint $table) {

            $table->id();

            $table->integer('numero_personas');

            $table->string('nombre_cliente', 150)->nullable();
            $table->string('email')->nullable();

            $table->enum('tipo', ['reservacion', 'walkin'])->default('walkin');
            $table->string('comentarios', 255)->nullable();
            $table->string('token_resena')->nullable();

            $table->dateTime('hora_entrada')->nullable();
            $table->dateTime('hora_salida')->nullable();

            $table->enum('estado', [
                'activa',
                'finalizada',
                'cancelada',
                'no_show'
            ])->default('activa');

            $table->foreignId('reservacion_id')
                ->nullable()
                ->constrained('reservaciones')
                ->nullOnDelete();

            $table->foreignId('cafe_id')
                ->constrained('cafeterias')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('mesa_id')
                ->constrained('mesas')
                ->cascadeOnDelete();

            $table->timestamps();
        });

        // Triggers for Mesas automation
        DB::unprepared('
            CREATE TRIGGER trg_ocupar_mesa_insert
            AFTER INSERT ON detalle_ocupaciones
            FOR EACH ROW
            BEGIN
                UPDATE mesas SET activo = false WHERE id = NEW.mesa_id;
            END
        ');

        DB::unprepared('
            CREATE TRIGGER trg_mover_mesa_update
            AFTER UPDATE ON detalle_ocupaciones
            FOR EACH ROW
            BEGIN
                IF OLD.mesa_id != NEW.mesa_id THEN
                    UPDATE mesas SET activo = true WHERE id = OLD.mesa_id;
                    UPDATE mesas SET activo = false WHERE id = NEW.mesa_id;
                END IF;
            END
        ');

        DB::unprepared('
            CREATE TRIGGER trg_liberar_mesa_delete
            AFTER DELETE ON detalle_ocupaciones
            FOR EACH ROW
            BEGIN
                UPDATE mesas SET activo = true WHERE id = OLD.mesa_id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_ocupar_mesa_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_mover_mesa_update');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_liberar_mesa_delete');

        Schema::dropIfExists('detalle_ocupaciones');
    }
};
