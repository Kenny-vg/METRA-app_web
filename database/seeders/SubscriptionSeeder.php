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
        //
        Suscripcion::create([
            'cafe_id' => 1,
            'plan_id' => 1,
            'fecha_inicio' => now(),
            'fecha_fin' => now()->addDays(30),
            'estado_pago' => 'pagado',
            'monto'=>799,
        ]);
    }
}
