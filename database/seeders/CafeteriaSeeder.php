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
        // 0. Obtener usuarios de prueba
        $gerente = \App\Models\User::where('email', 'gerente@metra.com')->first();
        $staff = \App\Models\User::where('email', 'staff@metra.com')->first();
        if (!$gerente || !$staff) return;

        // 1. Cafetería Principal
        $cafe = Cafeteria::updateOrCreate(
            ['slug' => 'metra-luxury'],
            [
                'nombre' => 'METRA Luxury Coffee',
                'descripcion' => 'Experiencia premium de café de especialidad y alta repostería.',
                'calle' => 'Paseo de la Reforma',
                'num_exterior' => '450',
                'colonia' => 'Juárez',
                'ciudad' => 'CDMX',
                'estado' => 'activa',
                'user_id' => $gerente->id,
                'porcentaje_reservas' => 80,
                'duracion_reserva_min' => 120,
            ]
        );

        // 2. Horarios Operativos
        $dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
        foreach ($dias as $dia) {
            \App\Models\Horario::updateOrCreate(
                ['dia_semana' => $dia, 'cafe_id' => $cafe->id],
                ['hora_apertura' => '08:00:00', 'hora_cierre' => '22:00:00', 'activo' => true]
            );
        }

        // 3. Infraestructura (Zonas y Mesas)
        $zonas = [
            ['nombre' => 'Salón Interior', 'capacidad' => 2, 'mesas' => 5],
            ['nombre' => 'Terraza Jardín', 'capacidad' => 4, 'mesas' => 4],
            ['nombre' => 'Área VIP', 'capacidad' => 6, 'mesas' => 2]
        ];

        foreach ($zonas as $index => $zData) {
            $zona = \App\Models\Zona::updateOrCreate(
                ['nombre_zona' => $zData['nombre'], 'cafe_id' => $cafe->id],
                ['activo' => true]
            );

            for ($i = 1; $i <= $zData['mesas']; $i++) {
                \App\Models\Mesa::updateOrCreate(
                    ['numero_mesa' => ($index * 10) + $i, 'zona_id' => $zona->id, 'cafe_id' => $cafe->id],
                    ['capacidad' => $zData['capacidad'], 'activo' => true]
                );
            }
        }

        // 4. Menú Digital
        $cat1 = \App\Models\MenuCategoria::create(['nombre' => 'Café de Especialidad', 'orden' => 1, 'activo' => true, 'cafe_id' => $cafe->id]);
        $cat2 = \App\Models\MenuCategoria::create(['nombre' => 'Repostería Artesanal', 'orden' => 2, 'activo' => true, 'cafe_id' => $cafe->id]);

        \App\Models\Menu::create(['nombre_producto' => 'Flat White', 'precio' => 65.00, 'categoria_id' => $cat1->id, 'cafe_id' => $cafe->id, 'activo' => true]);
        \App\Models\Menu::create(['nombre_producto' => 'V60 Chemex', 'precio' => 85.00, 'categoria_id' => $cat1->id, 'cafe_id' => $cafe->id, 'activo' => true]);
        \App\Models\Menu::create(['nombre_producto' => 'Croissant de Almendras', 'precio' => 55.00, 'categoria_id' => $cat2->id, 'cafe_id' => $cafe->id, 'activo' => true]);

        // 5. Ocasiones y Promociones
        $ocasion = \App\Models\OcasionEspecial::create(['nombre' => 'Aniversario', 'cafe_id' => $cafe->id]);

        // Promo ligada a ocasión
        $promo1 = \App\Models\Promocion::create([
            'nombre_promocion' => 'Cena Aniversario 2x1',
            'precio' => 450.00,
            'fecha_inicio' => now()->toDateString(),
            'fecha_fin' => now()->addDays(30)->toDateString(),
            'activo' => true,
            'cafe_id' => $cafe->id
        ]);
        $promo1->ocasiones()->attach($ocasion->id);

        // Promo General (No ligada a ocasión)
        \App\Models\Promocion::create([
            'nombre_promocion' => 'Lunes de Espresso',
            'precio' => 35.00,
            'dias_semana' => ['Lunes'],
            'activo' => true,
            'cafe_id' => $cafe->id
        ]);

        // 6. Auditoría y Métricas (Reservas -> Ocupaciones -> Reseñas)
        $comentarios = [
            'El café es espectacular y la atención de primera.',
            'La terraza tiene una vista increíble, muy tranquilo.',
            'Un poco ruidoso en el interior, pero la comida lo vale.'
        ];

        $mesaId = \App\Models\Mesa::where('cafe_id', $cafe->id)->first()->id;
        $zonaId = \App\Models\Zona::where('cafe_id', $cafe->id)->first()->id;

        foreach ($comentarios as $i => $texto) {
            $r = \App\Models\Reservacion::create([
                'folio' => 'AUDIT-00' . ($i + 1),
                'nombre_cliente' => 'Cliente Auditor ' . ($i + 1),
                'telefono' => '555111' . $i,
                'email' => 'audit' . $i . '@test.com',
                'fecha' => now()->subDays($i + 1)->toDateString(),
                'hora_inicio' => '10:00:00', 'hora_fin' => '11:30:00',
                'numero_personas' => 2,
                'estado' => 'finalizada',
                'cafe_id' => $cafe->id,
                'zona_id' => $zonaId
            ]);

            $o = \App\Models\DetalleOcupacion::create([
                'numero_personas' => 2, 'nombre_cliente' => $r->nombre_cliente, 'email' => $r->email,
                'tipo' => 'reservacion', 'estado' => 'finalizada', 'reservacion_id' => $r->id,
                'cafe_id' => $cafe->id, 'user_id' => $staff->id, 'mesa_id' => $mesaId,
                'hora_entrada' => now()->subDays($i + 1)->subMinutes(60),
                'hora_salida' => now()->subDays($i + 1)
            ]);

            \App\Models\Resena::create([
                'detalle_ocupacion_id' => $o->id, 'cafe_id' => $cafe->id,
                'calificacion' => 5 - ($i % 2), 'comentario' => $texto, 'estado' => 'publicada'
            ]);
        }

        // 7. Reserva para hoy (Dashboard actual)
        \App\Models\Reservacion::create([
            'folio' => 'DASH-HOY-01', 'nombre_cliente' => 'Visitante Hoy', 'telefono' => '5551234567',
            'fecha' => now()->toDateString(), 'hora_inicio' => '16:00:00', 'hora_fin' => '17:30:00',
            'numero_personas' => 3, 'estado' => 'pendiente', 'cafe_id' => $cafe->id, 'zona_id' => $zonaId
        ]);
    }
}
