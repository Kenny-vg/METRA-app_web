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
        // 1. VISTA: Analítica General (Capacidad y Fidelidad Unificada)
        DB::unprepared("
            CREATE OR REPLACE VIEW vw_analitica_gerente_general AS
            SELECT 
                c.id AS cafe_id,
                (SELECT SUM(capacidad) FROM mesas WHERE cafe_id = c.id AND activo = 1) AS capacidad_total,
                (SELECT COUNT(DISTINCT email) FROM reservaciones WHERE cafe_id = c.id AND email IS NOT NULL) AS clientes_unicos,
                (SELECT COUNT(*) FROM (
                    SELECT email, cafe_id
                    FROM reservaciones 
                    WHERE email IS NOT NULL 
                    GROUP BY cafe_id, email 
                    HAVING COUNT(*) > 1
                ) AS sub WHERE sub.cafe_id = c.id) AS clientes_recurrentes,
                (SELECT COUNT(*) FROM reservaciones WHERE cafe_id = c.id AND estado = 'no_show' AND fecha >= DATE_SUB(NOW(), INTERVAL 30 DAY)) AS no_shows_30_dias,
                (
                    (SELECT COUNT(*) FROM reservaciones WHERE cafe_id = c.id AND fecha >= DATE_SUB(NOW(), INTERVAL 30 DAY))
                    +
                    (SELECT COUNT(DISTINCT grupo_id) FROM detalle_ocupaciones WHERE cafe_id = c.id AND tipo = 'walkin' AND hora_entrada >= DATE_SUB(NOW(), INTERVAL 30 DAY))
                ) AS total_visitas_30_dias
            FROM cafeterias c;
        ");

        // 2. VISTA: Demanda Horaria Unificada (Mapa de Calor)
        DB::unprepared("
            CREATE OR REPLACE VIEW vw_demanda_horaria AS
            SELECT 
                cafe_id,
                hora,
                COUNT(*) AS total_servicios
            FROM (
                SELECT cafe_id, HOUR(hora_inicio) as hora FROM reservaciones WHERE estado != 'cancelada'
                UNION ALL
                SELECT cafe_id, HOUR(hora_entrada) as hora FROM detalle_ocupaciones WHERE tipo = 'walkin' AND estado != 'cancelada'
                GROUP BY cafe_id, HOUR(hora_entrada), grupo_id
            ) as unified
            GROUP BY cafe_id, hora;
        ");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP VIEW IF EXISTS vw_demanda_horaria');
        DB::unprepared('DROP VIEW IF EXISTS vw_analitica_gerente_general');
    }
};
