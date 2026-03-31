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
        // 0. Obtener usuarios para cada cafetería
        $gerenteMetra = \App\Models\User::where('email', 'gerente@metra.com')->first();
        $staffMetra = \App\Models\User::where('email', 'staff@metra.com')->first();
        
        $gerenteSabroso = \App\Models\User::where('email', 'sabroso@metra.com')->first();
        $staffSabroso = \App\Models\User::where('email', 'staff_sabroso@metra.com')->first();

        if (!$gerenteMetra || !$gerenteSabroso) return;

        // Sembrar METRA Luxury
        $this->seedCafeteria($gerenteMetra, $staffMetra, [
            'nombre' => 'METRA Luxury Coffee',
            'slug' => 'metra-luxury',
            'descripcion' => 'Experiencia premium de café de especialidad y alta repostería.',
            'zonas' => [
                ['nombre' => 'Salón Interior', 'capacidad' => 2, 'mesas' => 4],
                ['nombre' => 'Terraza Jardín', 'capacidad' => 4, 'mesas' => 4]
            ],
            'menu' => [
                ['cat' => 'Cafetería', 'items' => [['n' => 'Flat White', 'p' => 65], ['n' => 'V60', 'p' => 85]]],
                ['cat' => 'Postres', 'items' => [['n' => 'Tarta de Queso', 'p' => 95]]]
            ]
        ]);

        // Sembrar Café Sabroso
        $this->seedCafeteria($gerenteSabroso, $staffSabroso, [
            'nombre' => 'Café Sabroso',
            'slug' => 'cafe-sabroso',
            'descripcion' => 'El sabor de la tradición en cada taza. Ambiente familiar y acogedor.',
            'zonas' => [
                ['nombre' => 'Barra Principal', 'capacidad' => 2, 'mesas' => 3],
                ['nombre' => 'Patio Tradicional', 'capacidad' => 6, 'mesas' => 5]
            ],
            'menu' => [
                ['cat' => 'Tradición', 'items' => [['n' => 'Café de Olla', 'p' => 45], ['n' => 'Chocolate Abuelita', 'p' => 50]]],
                ['cat' => 'Panadería', 'items' => [['n' => 'Concha con Nata', 'p' => 40], ['n' => 'Mollete Clásico', 'p' => 75]]]
            ]
        ]);
    }

    private function seedCafeteria($gerente, $staff, $data)
    {
        $cafe = Cafeteria::updateOrCreate(
            ['slug' => $data['slug']],
            [
                'nombre' => $data['nombre'],
                'descripcion' => $data['descripcion'],
                'estado' => 'activa',
                'user_id' => $gerente->id,
                'porcentaje_reservas' => 85,
                'duracion_reserva_min' => 90,
            ]
        );

        // Horarios
        foreach (['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'] as $dia) {
            \App\Models\Horario::updateOrCreate(['dia_semana' => $dia, 'cafe_id' => $cafe->id], ['hora_apertura' => '08:00', 'hora_cierre' => '22:00', 'activo' => true]);
        }

        // Zonas y Mesas
        foreach ($data['zonas'] as $zIdx => $z) {
            $zona = \App\Models\Zona::create(['nombre_zona' => $z['nombre'], 'activo' => true, 'cafe_id' => $cafe->id]);
            for ($i = 1; $i <= $z['mesas']; $i++) {
                \App\Models\Mesa::create(['numero_mesa' => ($zIdx * 10) + $i, 'capacidad' => $z['capacidad'], 'activo' => true, 'zona_id' => $zona->id, 'cafe_id' => $cafe->id]);
            }
        }

        // Menú
        foreach ($data['menu'] as $c) {
            $cat = \App\Models\MenuCategoria::create(['nombre' => $c['cat'], 'activo' => true, 'cafe_id' => $cafe->id, 'orden' => 1]);
            foreach ($c['items'] as $it) {
                \App\Models\Menu::create(['nombre_producto' => $it['n'], 'precio' => $it['p'], 'categoria_id' => $cat->id, 'cafe_id' => $cafe->id, 'activo' => true]);
            }
        }

        // Una promo general
        \App\Models\Promocion::create([
            'nombre_promocion' => 'Promo ' . $data['nombre'],
            'precio' => 50.00,
            'activo' => true,
            'cafe_id' => $cafe->id
        ]);

        // Simular una reserva auditada con reseña
        $reserva = \App\Models\Reservacion::create([
            'folio' => 'AUDIT-' . $data['slug'], 'nombre_cliente' => 'Cliente ' . $data['nombre'], 'telefono' => '555000111',
            'fecha' => now()->subDay()->toDateString(), 'hora_inicio' => '10:00', 'hora_fin' => '11:00', 'numero_personas' => 2,
            'estado' => 'finalizada', 'cafe_id' => $cafe->id, 'zona_id' => \App\Models\Zona::where('cafe_id', $cafe->id)->first()->id
        ]);

        $ocupacion = \App\Models\DetalleOcupacion::create([
            'numero_personas' => 2, 'tipo' => 'reservacion', 'estado' => 'finalizada', 'reservacion_id' => $reserva->id,
            'cafe_id' => $cafe->id, 'user_id' => $staff->id, 'mesa_id' => \App\Models\Mesa::where('cafe_id', $cafe->id)->first()->id
        ]);

        \App\Models\Resena::create([
            'detalle_ocupacion_id' => $ocupacion->id, 'cafe_id' => $cafe->id, 'calificacion' => 5,
            'comentario' => '¡Me encanta ' . $data['nombre'] . '!', 'estado' => 'publicada'
        ]);
    }
}
