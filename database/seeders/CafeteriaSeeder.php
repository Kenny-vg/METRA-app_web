<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cafeteria;
use App\Models\User;
use App\Models\Horario;
use App\Models\Zona;
use App\Models\Mesa;
use App\Models\MenuCategoria;
use App\Models\Menu;
use App\Models\OcasionEspecial;
use App\Models\Promocion;
use App\Models\Reservacion;
use App\Models\DetalleOcupacion;
use App\Models\Resena;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CafeteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 0. Obtener usuarios para cada cafetería
        $gerenteMetra = User::where('email', 'gerente@metra.com')->first();
        $staffMetra = User::where('email', 'staff@metra.com')->first();
        
        $gerenteSabroso = User::where('email', 'sabroso@metra.com')->first();
        $staffSabroso = User::where('email', 'staff_sabroso@metra.com')->first();

        if (!$gerenteMetra || !$gerenteSabroso) return;

        // Sembrar METRA Luxury
        $this->seedCafeteria($gerenteMetra, $staffMetra, [
            'nombre' => 'METRA Luxury Coffee',
            'slug' => 'metra-luxury',
            'descripcion' => 'Experiencia premium de café de especialidad y alta repostería.',
            'calle' => 'Av. Presidente Masaryk',
            'num_exterior' => '123',
            'colonia' => 'Polanco',
            'estado_republica' => 'Ciudad de México',
            'ciudad' => 'Miguel Hidalgo',
            'cp' => '11560',
            'telefono' => '5551234567',
            'zonas' => [
                ['nombre' => 'Salón Principal', 'capacidad' => 2, 'mesas' => 6],
                ['nombre' => 'Terraza Exclusive', 'capacidad' => 4, 'mesas' => 4],
                ['nombre' => 'Barra de Especialidad', 'capacidad' => 1, 'mesas' => 4]
            ],
            'menu' => [
                ['cat' => 'Café Caliente', 'items' => [
                    ['n' => 'Flat White', 'p' => 65, 'd' => 'Espresso doble con leche cremada.'],
                    ['n' => 'Latte Macchiato', 'p' => 70, 'd' => 'Tres capas de leche y espresso.'],
                    ['n' => 'V60 Pour Over', 'p' => 85, 'd' => 'Café de especialidad filtrado.']
                ]],
                ['cat' => 'Bebidas Frías', 'items' => [
                    ['n' => 'Cold Brew Nitro', 'p' => 75, 'd' => 'Infusión en frío con nitrógeno.'],
                    ['n' => 'Frappé Metra', 'p' => 95, 'd' => 'Mezcla secreta de la casa con chocolate.']
                ]],
                ['cat' => 'Postres', 'items' => [
                    ['n' => 'Tarta de Queso', 'p' => 110, 'd' => 'Receta vasca con frutos rojos.'],
                    ['n' => 'Macarons (3 pzs)', 'p' => 85, 'd' => 'Selección de sabores franceses.']
                ]]
            ],
            'ocasiones' => [
                ['nombre' => 'Cumpleaños'], ['nombre' => 'Aniversario'], ['nombre' => 'Negocios']
            ],
            'promociones' => [
                ['nombre' => 'Cortesía Cumpleañera', 'precio' => 0.00, 'desc' => 'Pastel individual de cortesía para el cumpleañero.'],
                ['nombre' => 'Brunch Ejecutivo', 'precio' => 180.00, 'desc' => 'Café + Alimento + Jugo natural.']
            ]
        ]);

        // Sembrar Café Sabroso
        $this->seedCafeteria($gerenteSabroso, $staffSabroso, [
            'nombre' => 'Café Sabroso',
            'slug' => 'cafe-sabroso',
            'descripcion' => 'El sabor de la tradición en cada taza. Ambiente familiar y acogedor.',
            'calle' => 'Calle Libertad',
            'num_exterior' => '456',
            'colonia' => 'Americana',
            'estado_republica' => 'Jalisco',
            'ciudad' => 'Guadalajara',
            'cp' => '44160',
            'telefono' => '3339876543',
            'zonas' => [
                ['nombre' => 'Patio Tradicional', 'capacidad' => 6, 'mesas' => 5],
                ['nombre' => 'Barra Clásica', 'capacidad' => 2, 'mesas' => 4],
                ['nombre' => 'Salón Familiar', 'capacidad' => 4, 'mesas' => 6]
            ],
            'menu' => [
                ['cat' => 'Tradición Mexicana', 'items' => [
                    ['n' => 'Café de Olla', 'p' => 45, 'd' => 'Endulzado con piloncillo y canela.'],
                    ['n' => 'Chocolate Abuelita', 'p' => 50, 'd' => 'Clásico chocolate caliente espumoso.']
                ]],
                ['cat' => 'Antojitos', 'items' => [
                    ['n' => 'Concha con Nata', 'p' => 55, 'd' => 'Pan dulce artesanal con nata natural.'],
                    ['n' => 'Molletes Divorciados', 'p' => 95, 'd' => 'Con salsa verde y roja picante.']
                ]]
            ],
            'ocasiones' => [
                ['nombre' => 'Familiar'], ['nombre' => 'Reunión Amigos'], ['nombre' => 'Primera Cita']
            ],
            'promociones' => [
                ['nombre' => 'Desayuno Sabroso 2x1', 'precio' => 120.00, 'desc' => 'Segunda orden de molletes al 50%.'],
                ['nombre' => 'Cortesía de Primera Cita', 'precio' => 0.00, 'desc' => 'Dos mini brownies decorados para la pareja.']
            ]
        ]);
    }

    private function seedCafeteria($gerente, $staff, $data)
    {
        // 1. Crear Cafetería
        $cafe = Cafeteria::updateOrCreate(
            ['slug' => $data['slug']],
            [
                'nombre' => $data['nombre'],
                'descripcion' => $data['descripcion'],
                'calle' => $data['calle'] ?? null,
                'num_exterior' => $data['num_exterior'] ?? null,
                'colonia' => $data['colonia'] ?? null,
                'estado_republica' => $data['estado_republica'] ?? null,
                'ciudad' => $data['ciudad'] ?? null,
                'cp' => $data['cp'] ?? null,
                'telefono' => $data['telefono'] ?? null,
                'estado' => 'activa',
                'user_id' => $gerente->id,
                'porcentaje_reservas' => 85,
                'duracion_reserva_min' => 60,
                'intervalo_reserva_min' => 30,
                'tolerancia_reserva_min' => 15
            ]
        );

        // 2. Horarios
        foreach (['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'] as $dia) {
            Horario::updateOrCreate(['dia_semana' => $dia, 'cafe_id' => $cafe->id], ['hora_apertura' => '07:00', 'hora_cierre' => '23:00', 'activo' => true]);
        }

        // 3. Ocasiones
        $ocasionesIds = [];
        foreach ($data['ocasiones'] as $oc) {
            $obj = OcasionEspecial::updateOrCreate(['nombre' => $oc['nombre'], 'cafe_id' => $cafe->id], ['activo' => true]);
            $ocasionesIds[] = $obj->id;
        }

        // 4. Zonas y Mesas
        $zonasIds = [];
        foreach ($data['zonas'] as $zIdx => $z) {
            $zona = Zona::updateOrCreate(['nombre_zona' => $z['nombre'], 'cafe_id' => $cafe->id], ['activo' => true]);
            $zonasIds[] = $zona->id;
            for ($i = 1; $i <= $z['mesas']; $i++) {
                Mesa::updateOrCreate(
                    ['numero_mesa' => ($zIdx * 10) + $i, 'cafe_id' => $cafe->id, 'zona_id' => $zona->id],
                    ['capacidad' => $z['capacidad'], 'activo' => true]
                );
            }
        }

        // 5. Menú
        foreach ($data['menu'] as $idx => $c) {
            $cat = MenuCategoria::updateOrCreate(['nombre' => $c['cat'], 'cafe_id' => $cafe->id], ['activo' => true, 'orden' => $idx + 1]);
            foreach ($c['items'] as $it) {
                Menu::updateOrCreate(
                    ['nombre_producto' => $it['n'], 'cafe_id' => $cafe->id, 'categoria_id' => $cat->id],
                    ['precio' => $it['p'], 'descripcion' => $it['d'], 'activo' => true]
                );
            }
        }

        // 6. Promociones
        $promosIds = [];
        foreach ($data['promociones'] as $p) {
            $promo = Promocion::updateOrCreate(
                ['nombre_promocion' => $p['nombre'], 'cafe_id' => $cafe->id],
                ['precio' => $p['precio'], 'descripcion' => $p['desc'], 'activo' => true]
            );
            $promosIds[] = $promo->id;
        }

        // 7. HISTORIAL PARA MINERÍA DE DATOS (Últimos 14 días + Próximos 3)
        $this->seedHistoricalData($cafe, $staff, $zonasIds, $ocasionesIds, $promosIds);
    }

    private function seedHistoricalData($cafe, $staff, $zonas, $ocasiones, $promos)
    {
        $startDate = Carbon::now()->subDays(14);
        $endDate = Carbon::now()->addDays(3);

        $clientNames = ['Alejandro', 'Beatriz', 'Carlos', 'Daniela', 'Eduardo', 'Fernanda', 'Gustavo', 'Hilda'];
        $lastNames = ['Hernandez', 'Gomez', 'Perez', 'Ruiz', 'Lopez', 'Garcia', 'Torres'];

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            
            // Cantidad de reservas por dia (Cargar más los fines de semana)
            $count = $date->isWeekend() ? rand(5, 8) : rand(2, 4);
            
            for ($i = 0; $i < $count; $i++) {
                $status = 'finalizada'; // Defecto histórico
                
                if ($date->isFuture()) {
                    $status = 'pendiente';
                } else {
                    $roll = rand(1, 100);
                    if ($roll > 90) $status = 'cancelada';
                    else if ($roll > 80) $status = 'no_show';
                }

                // Horario pico vs normal
                $hour = rand(8, 21);
                $minute = (rand(0, 1) === 0) ? '00' : '30';
                $horaInicioStr = sprintf('%02d:%s', $hour, $minute);
                $horaInicio = Carbon::parse($date->toDateString() . ' ' . $horaInicioStr);
                $horaFin = $horaInicio->copy()->addMinutes($cafe->duracion_reserva_min);

                $cliente = $clientNames[array_rand($clientNames)] . ' ' . $lastNames[array_rand($lastNames)];
                
                $rsv = Reservacion::create([
                    'folio' => 'SEED-' . Str::upper(Str::random(5)),
                    'nombre_cliente' => $cliente,
                    'telefono' => '55' . rand(10000000, 99999999),
                    'email' => strtolower(Str::slug($cliente)) . '@test.com',
                    'fecha' => $date->toDateString(),
                    'hora_inicio' => $horaInicio->format('H:i:s'),
                    'hora_fin' => $horaFin->format('H:i:s'),
                    'numero_personas' => rand(1, 5),
                    'estado' => $status,
                    'cafe_id' => $cafe->id,
                    'zona_id' => $zonas[array_rand($zonas)],
                    'ocasion_especial_id' => (rand(0, 1) === 0) ? $ocasiones[array_rand($ocasiones)] : null,
                    'promocion_id' => (rand(0, 1) === 0) ? $promos[array_rand($promos)] : null
                ]);

                // Si está finalizada, crear ocupación y reseña
                if ($status === 'finalizada') {
                    $mesaAsignada = Mesa::where('cafe_id', $cafe->id)->where('zona_id', $rsv->zona_id)->inRandomOrder()->first();
                    
                    $ocupacion = DetalleOcupacion::create([
                        'numero_personas' => $rsv->numero_personas,
                        'tipo' => 'reservacion',
                        'estado' => 'finalizada',
                        'reservacion_id' => $rsv->id,
                        'cafe_id' => $cafe->id,
                        'user_id' => $staff->id,
                        'mesa_id' => $mesaAsignada ? $mesaAsignada->id : null,
                        'fecha_checkin' => $horaInicio->copy()->addMinutes(rand(-10, 5)),
                        'fecha_checkout' => $horaFin->copy()->addMinutes(rand(0, 30))
                    ]);

                    // 60% chance de reseña
                    if (rand(1, 10) <= 6) {
                        Resena::create([
                            'detalle_ocupacion_id' => $ocupacion->id,
                            'cafe_id' => $cafe->id,
                            'calificacion' => rand(4, 5),
                            'comentario' => 'Excelente experiencia en ' . $cafe->nombre,
                            'estado' => 'publicada'
                        ]);
                    }
                }
            }
        }
    }
}
