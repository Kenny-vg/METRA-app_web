<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cafeteria;

class CafeteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // 1. Cafetería Principal
        $cafe = Cafeteria::updateOrCreate(
            ['slug' => 'metra-luxury-demo'],
            [
                'nombre' => 'METRA Luxury Coffee',
                'descripcion' => 'Experiencia premium de café y gastronomía urbana.',
                'calle' => 'Av. Reforma',
                'num_exterior' => '123',
                'colonia' => 'Centro',
                'ciudad' => 'CDMX',
                'estado' => 'activa',
                'porcentaje_reservas' => 70,
                'duracion_reserva_min' => 90,
            ]
        );

        // 2. Zonas
        $zonaInterior = \App\Models\Zona::updateOrCreate(
            ['nombre_zona' => 'Interior Climatizado', 'cafe_id' => $cafe->id],
            ['activo' => true]
        );

        $zonaTerraza = \App\Models\Zona::updateOrCreate(
            ['nombre_zona' => 'Terraza Panorámica', 'cafe_id' => $cafe->id],
            ['activo' => true]
        );

        // 3. Mesas (Para Zona Interior)
        for ($i = 1; $i <= 5; $i++) {
            \App\Models\Mesa::updateOrCreate(
                ['numero_mesa' => 'I-' . $i, 'cafe_id' => $cafe->id],
                [
                    'capacidad' => ($i % 2 == 0) ? 4 : 2,
                    'ubicacion' => 'Planta Baja',
                    'zona_id' => $zonaInterior->id,
                    'activo' => true
                ]
            );
        }

        // Mesas (Para Zona Terraza)
        for ($i = 1; $i <= 5; $i++) {
            \App\Models\Mesa::updateOrCreate(
                ['numero_mesa' => 'T-' . $i, 'cafe_id' => $cafe->id],
                [
                    'capacidad' => ($i > 3) ? 6 : 4,
                    'ubicacion' => 'Piso 2',
                    'zona_id' => $zonaTerraza->id,
                    'activo' => true
                ]
            );
        }

        // 4. Reservaciones (Datos para métricas y auditoría)
        // Reservas pasadas (Finalizadas)
        for ($i = 1; $i <= 5; $i++) {
            \App\Models\Reservacion::create([
                'folio' => 'RES-PAST-' . $i,
                'nombre_cliente' => 'Cliente Histórico ' . $i,
                'telefono' => '555123456' . $i,
                'email' => 'cliente' . $i . '@test.com',
                'fecha' => now()->subDays($i + 2)->toDateString(),
                'hora_inicio' => '14:00:00',
                'hora_fin' => '15:30:00',
                'numero_personas' => 2,
                'estado' => 'finalizada',
                'cafe_id' => $cafe->id,
                'zona_id' => $zonaInterior->id
            ]);
        }

        // Reservas para hoy
        \App\Models\Reservacion::create([
            'folio' => 'RES-HOY-1',
            'nombre_cliente' => 'Juan Pérez',
            'telefono' => '5559876543',
            'email' => 'juan@test.com',
            'fecha' => now()->toDateString(),
            'hora_inicio' => '10:00:00',
            'hora_fin' => '11:30:00',
            'numero_personas' => 4,
            'estado' => 'pendiente',
            'cafe_id' => $cafe->id,
            'zona_id' => $zonaTerraza->id
        ]);

        // Reservas canceladas (Auditoría)
        \App\Models\Reservacion::create([
            'folio' => 'RES-CAN-1',
            'nombre_cliente' => 'Cliente Arrepentido',
            'telefono' => '5550000000',
            'fecha' => now()->addDays(1)->toDateString(),
            'hora_inicio' => '12:00:00',
            'hora_fin' => '13:30:00',
            'numero_personas' => 2,
            'estado' => 'cancelada',
            'cafe_id' => $cafe->id,
            'zona_id' => $zonaInterior->id
        ]);

        // 5. Reseñas (Para el promedio de calificación)
        $clientes = ['Ana García', 'Luis Torres', 'Marta Solis'];
        foreach ($clientes as $index => $nombre) {
            \App\Models\Resena::create([
                'cafe_id' => $cafe->id,
                'calificacion' => 5 - ($index % 2),
                'comentario' => 'Excelente servicio y ambiente.',
                'estado' => 'publicada'
            ]);
        }
    }
}
