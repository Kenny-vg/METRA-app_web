<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Suscripcion;
use App\Models\Plan;
use App\Models\Cafeteria;
use Carbon\Carbon;

class SuscripcionActivaSeeder extends Seeder
{
    public function run(): void
{
    $cafeteria = Cafeteria::first();

    if (!$cafeteria) {
        $this->command->error('No existe ninguna cafetería.');
        return;
    }

    $plan = Plan::first();

    if (!$plan) {
        $plan = Plan::updateOrCreate([
            'nombre_plan' => 'Plan Demo',
            'precio' => 299,
            'duracion_dias' => 30,
            'max_reservas_mes' => 100,
            'max_usuarios_admin' => 2,
            'estado' => true
        ]);
    }

    Suscripcion::where('cafe_id', $cafeteria->id)->delete();

    Suscripcion::updateOrCreate([
        'cafe_id' => $cafeteria->id,
        'plan_id' => $plan->id,
        'fecha_inicio' => Carbon::now(),
        'fecha_fin' => Carbon::now()->addMonths(6),
        'estado_pago' => 'pagado',
        'monto' => $plan->precio,
        'user_id' => $cafeteria->user_id,
        'fecha_validacion' => Carbon::now()
    ]);

    $this->command->info('Suscripción activa creada correctamente.');
    }
}