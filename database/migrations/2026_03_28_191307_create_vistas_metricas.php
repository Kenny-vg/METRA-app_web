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
        // 1. VISTA NATIVA: Reporte Diario de Ocupación Unificado
        DB::unprepared("
            CREATE OR REPLACE VIEW vw_reporte_diario AS
            SELECT 
                cafe_id,
                fecha,
                COUNT(CASE WHEN tipo = 'reserva' THEN 1 END) AS total_reservas,
                SUM(CASE WHEN tipo = 'reserva' AND estado = 'finalizada' THEN 1 ELSE 0 END) AS reservas_completadas,
                SUM(CASE WHEN tipo = 'reserva' AND estado = 'cancelada' THEN 1 ELSE 0 END) AS reservas_canceladas,
                SUM(CASE WHEN tipo = 'reserva' AND estado = 'no_show' THEN 1 ELSE 0 END) AS no_shows,
                COUNT(CASE WHEN tipo = 'walkin' THEN 1 END) AS total_walkins,
                SUM(numero_personas) AS total_comensales_reales
            FROM (
                SELECT cafe_id, fecha, 'reserva' as tipo, estado, numero_personas FROM reservaciones
                UNION ALL
                SELECT cafe_id, DATE(hora_entrada) as fecha, 'walkin' as tipo, estado, SUM(numero_personas) as numero_personas
                FROM detalle_ocupaciones
                WHERE tipo = 'walkin'
                GROUP BY cafe_id, DATE(hora_entrada), grupo_id, estado, tipo
            ) as unified
            GROUP BY cafe_id, fecha;
        ");

        // 2. VISTA MATERIALIZADA (Simulada para MySQL): Tabla física
        Schema::create('mv_metricas_mensuales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cafe_id');
            $table->integer('anio');
            $table->integer('mes');
            
            // Métricas del dominio METRA solicitadas
            $table->integer('total_reservaciones')->default(0);
            $table->integer('cancelaciones')->default(0);
            $table->integer('clientes_atendidos')->default(0);
            $table->decimal('porcentaje_efectividad', 5, 2)->default(0); // finalizadas vs creadas
            
            // Un índice único compuesto para evitar duplicados en el mismo mes/año para la misma cafetería
            $table->unique(['cafe_id', 'anio', 'mes']);
            $table->timestamp('ultima_actualizacion')->useCurrent();
        });

        // 3. STORED PROCEDURE: Motor de actualización de métricas mensuales
        DB::unprepared("
            DROP PROCEDURE IF EXISTS sp_refresh_mv_metricas_mensuales;
            CREATE PROCEDURE sp_refresh_mv_metricas_mensuales()
            BEGIN
                TRUNCATE TABLE mv_metricas_mensuales;

                INSERT INTO mv_metricas_mensuales 
                (cafe_id, anio, mes, total_reservaciones, cancelaciones, clientes_atendidos, porcentaje_efectividad, ultima_actualizacion)
                SELECT 
                    cafe_id,
                    YEAR(fecha) AS anio,
                    MONTH(fecha) AS mes,
                    SUM(CASE WHEN tipo = 'reserva' THEN 1 ELSE 0 END) AS total_reservaciones,
                    SUM(CASE WHEN tipo = 'reserva' AND estado = 'cancelada' THEN 1 ELSE 0 END) AS cancelaciones,
                    SUM(CASE WHEN estado IN ('finalizada', 'en_curso', 'activa') THEN numero_personas ELSE 0 END) AS clientes_atendidos,
                    IFNULL((SUM(CASE WHEN tipo = 'reserva' AND estado = 'finalizada' THEN 1 ELSE 0 END) / NULLIF(SUM(CASE WHEN tipo = 'reserva' THEN 1 ELSE 0 END), 0)) * 100, 0) AS porcentaje_efectividad,
                    NOW()
                FROM (
                    SELECT cafe_id, fecha, 'reserva' as tipo, estado, numero_personas FROM reservaciones
                    UNION ALL
                    SELECT cafe_id, DATE(hora_entrada) as fecha, 'walkin' as tipo, estado, SUM(numero_personas) as numero_personas
                    FROM detalle_ocupaciones
                    WHERE tipo = 'walkin'
                    GROUP BY cafe_id, DATE(hora_entrada), grupo_id, estado, tipo
                ) as unified
                GROUP BY cafe_id, YEAR(fecha), MONTH(fecha);
            END;
        ");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_refresh_mv_metricas_mensuales');
        Schema::dropIfExists('mv_metricas_mensuales');
        DB::unprepared('DROP VIEW IF EXISTS vw_reporte_diario');
    }
};
