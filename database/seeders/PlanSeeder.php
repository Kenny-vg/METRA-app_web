<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::updateOrCreate(
            ['nombre_plan' => 'Basic'],
            [
                'precio' => 199,
                'max_reservas_mes' => 150,
                'max_usuarios_admin' => 3,
                'duracion_dias' => 30,
                'descripcion' => 'Plan esencial para cafeterías boutique.',
                'estado' => 1,
                'tiene_metricas_avanzadas' => false,
                'tiene_recordatorios' => false,
            ]
        );

        Plan::updateOrCreate(
            ['nombre_plan' => 'Standard'],
            [
                'precio' => 399,
                'max_reservas_mes' => 500,
                'max_usuarios_admin' => 6,
                'duracion_dias' => 30,
                'descripcion' => 'Crecimiento y gestión de equipo con analítica.',
                'estado' => 1,
                'tiene_metricas_avanzadas' => true,
                'tiene_recordatorios' => false,
            ]
        );
        
        Plan::updateOrCreate(
            ['nombre_plan' => 'Premium'],
            [
                'precio' => 499,
                'max_reservas_mes' => 1000,
                'max_usuarios_admin' => 15,
                'duracion_dias' => 30,
                'descripcion' => 'Potencia total con recordatorios y métricas avanzadas.',
                'estado' => 1,
                'tiene_metricas_avanzadas' => true,
                'tiene_recordatorios' => true,
            ]
        );
    }
}
