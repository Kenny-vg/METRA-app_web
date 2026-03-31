<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Suscripcion;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plan = \App\Models\Plan::first();
        if (!$plan) return;

        $cafeterias = \App\Models\Cafeteria::all();

        foreach ($cafeterias as $cafe) {
            Suscripcion::updateOrCreate(
                ['cafe_id' => $cafe->id],
                [
                    'plan_id' => $plan->id,
                    'fecha_inicio' => now(),
                    'fecha_fin' => now()->addDays(30),
                    'estado_pago' => 'pagado',
                    'monto' => $plan->precio,
                ]
            );
        }
    }
}
