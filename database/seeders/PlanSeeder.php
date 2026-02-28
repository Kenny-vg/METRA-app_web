<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Plan::firstOrCreate([
            'nombre_plan' => 'Plan Demo',
            'precio' => 799,
            'max_reservas_mes' => 100,
            'max_usuarios_admin' => 5,
            'duracion_dias' => 30,

            'descripcion' => 'Plan de prueba para desarrollo',
            'estado' => 1,
        ]);
        
    }
}
