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
        Schema::create('bitacora_reservaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservacion_id')->constrained('reservaciones')->cascadeOnDelete();
            $table->string('accion');
            $table->string('estado_anterior')->nullable();
            $table->string('estado_nuevo')->nullable();
            $table->timestamp('fecha_cambio')->useCurrent();
        });

        // Triggers for Reservaciones Audit
        DB::unprepared("
            CREATE TRIGGER trg_auditoria_reserva_insert
            AFTER INSERT ON reservaciones
            FOR EACH ROW
            BEGIN
                INSERT INTO bitacora_reservaciones (reservacion_id, accion, estado_nuevo, fecha_cambio)
                VALUES (NEW.id, 'CREACION', NEW.estado, NOW());
            END
        ");

        DB::unprepared("
            CREATE TRIGGER trg_auditoria_reserva_update
            AFTER UPDATE ON reservaciones
            FOR EACH ROW
            BEGIN
                IF NEW.estado != OLD.estado THEN
                    INSERT INTO bitacora_reservaciones (reservacion_id, accion, estado_anterior, estado_nuevo, fecha_cambio)
                    VALUES (NEW.id, 'CAMBIO_ESTADO', OLD.estado, NEW.estado, NOW());
                END IF;
            END
        ");

        DB::unprepared("
            CREATE TRIGGER trg_auditoria_reserva_delete
            AFTER DELETE ON reservaciones
            FOR EACH ROW
            BEGIN
                INSERT INTO bitacora_reservaciones (reservacion_id, accion, estado_anterior, fecha_cambio)
                VALUES (OLD.id, 'ELIMINACION_FISICA', OLD.estado, NOW());
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_auditoria_reserva_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_auditoria_reserva_update');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_auditoria_reserva_delete');
        
        Schema::dropIfExists('bitacora_reservaciones');
    }
};
