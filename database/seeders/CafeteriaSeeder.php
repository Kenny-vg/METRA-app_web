<?php

namespace Database\Seeders;

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
use App\Models\Plan;
use App\Models\Suscripcion;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CafeteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 0. Obtener usuarios para Luxury
        $gerenteMetra = User::where('email', 'gerente@metra.com')->first();
        $staffMetra = User::where('email', 'staff@metra.com')->first();
        
        if (!$gerenteMetra) return;

        // Sembrar METRA Luxury
        $this->seedCafeteria($gerenteMetra, $staffMetra, [
            'nombre' => 'METRA Luxury Coffee',
            'slug' => 'metra-luxury',
            'descripcion' => 'Experiencia premium de café de especialidad y alta repostería en el corazón de Polanco.',
            'calle' => 'Av. Presidente Masaryk',
            'num_exterior' => '123',
            'colonia' => 'Polanco',
            'estado_republica' => 'Ciudad de México',
            'ciudad' => 'Miguel Hidalgo',
            'cp' => '11560',
            'telefono' => '5551234567',
            'zonas' => [
                ['nombre' => 'Salón Principal', 'capacidad' => 2, 'mesas' => 8],
                ['nombre' => 'Terraza Exclusive', 'capacidad' => 4, 'mesas' => 6],
                ['nombre' => 'Barra de Especialidad', 'capacidad' => 1, 'mesas' => 5]
            ],
            'menu' => [
                ['cat' => 'Café de Especialidad', 'items' => [
                    ['n' => 'Flat White', 'p' => 75, 'd' => 'Espresso de origen con leche cremada a temperatura perfecta.'],
                    ['n' => 'Latte Macchiato ART', 'p' => 85, 'd' => 'Tres capas de leche y espresso con arte latte premium.'],
                    ['n' => 'V60 Pour Over', 'p' => 110, 'd' => 'Café de especialidad filtrado con notas frutales (Etiopía o Colombia).']
                ]],
                ['cat' => 'Bebidas Signature', 'items' => [
                    ['n' => 'Cold Brew Nitro Gold', 'p' => 95, 'd' => 'Infusión en frío de 18 horas con nitrógeno y un toque cítrico.'],
                    ['n' => 'Affogato Metra', 'p' => 105, 'd' => 'Helado de vainilla artesanal bañado en un shot de espresso intenso.']
                ]],
                ['cat' => 'Alta Repostería', 'items' => [
                    ['n' => 'Tarta del Cielo', 'p' => 145, 'd' => 'Base crujiente con mousse de queso y jalea de frutos rojos orgánicos.'],
                    ['n' => 'Croissant de Almendras', 'p' => 85, 'd' => 'Masa hojaldrada mantequillosa con relleno cremoso de almendras tostadas.'],
                    ['n' => 'Macarons Premium (6 pzs)', 'p' => 220, 'd' => 'Caja de selección de autor: Lavanda, Pistache, Frambuesa.']
                ]]
            ],
            'ocasiones' => [
                ['nombre' => 'Cena Romántica'], ['nombre' => 'Cumpleaños VIP'], ['nombre' => 'Reunión de Negocios']
            ],
            'promociones' => [
                ['nombre' => 'Experiencia Cumpleañera', 'precio' => 0.00, 'desc' => 'Mini tarta de autor y velita para el cumpleañero.'],
                ['nombre' => 'Maridaje Matutino', 'precio' => 165.00, 'desc' => 'Café de especialidad + Repostería fina a elección.']
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
                'porcentaje_reservas' => 90,
                'duracion_reserva_min' => 90,
                'intervalo_reserva_min' => 30,
                'tolerancia_reserva_min' => 15
            ]
        );

        // Actualizar el gerente con el cafe_id
        $gerente->update(['cafe_id' => $cafe->id]);
        if ($staff) $staff->update(['cafe_id' => $cafe->id]);

        // 2. Horarios
        foreach (['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'] as $dia) {
            Horario::updateOrCreate(['dia_semana' => $dia, 'cafe_id' => $cafe->id], ['hora_apertura' => '07:00', 'hora_cierre' => '23:30', 'activo' => true]);
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

        // 6.5 Asegurar Suscripción Activa (Premium)
        $plan = Plan::where('nombre_plan', 'Premium')->first();
        if (!$plan) {
            $plan = Plan::create([
                'nombre_plan' => 'Premium',
                'precio' => 499,
                'max_reservas_mes' => 1000,
                'max_usuarios_admin' => 15,
                'duracion_dias' => 30,
                'estado' => 1,
                'tiene_metricas_avanzadas' => true,
                'tiene_recordatorios' => true
            ]);
        }

        Suscripcion::updateOrCreate(
            ['cafe_id' => $cafe->id, 'estado_pago' => 'pagado'],
            [
                'plan_id' => $plan->id,
                'user_id' => $gerente->id,
                'fecha_inicio' => Carbon::now()->subDays(15),
                'fecha_fin' => Carbon::now()->addDays(15),
                'monto' => $plan->precio,
                'fecha_validacion' => Carbon::now()
            ]
        );

        // 7. HISTORIAL PARA DEMO (Reservas, Ocupaciones y Reseñas)
        $this->seedHistoricalData($cafe, $staff, $zonasIds, $ocasionesIds, $promosIds);
    }

    private function seedHistoricalData($cafe, $staff, $zonas, $ocasiones, $promos)
    {
        $startDate = Carbon::now()->subDays(30); // Últimos 30 días
        $endDate = Carbon::now();

        $clientNames = ['Alejandro', 'Beatriz', 'Carlos', 'Daniela', 'Eduardo', 'Fernanda', 'Gustavo', 'Hilda', 'Ignacio', 'Julia', 'Roberto', 'Mariana', 'Esteban', 'Paola'];
        $lastNames = ['Hernández', 'Gómez', 'Pérez', 'Ruiz', 'López', 'Sánchez', 'Torres', 'Ramírez'];
        
        $reviews = [
            'Excelente servicio y el café es insuperable. El Flat White es el mejor que he probado.',
            'Lugar muy elegante y tranquilo, perfecto para mis reuniones de negocios.',
            'La terraza es hermosa y el personal muy atento. Volveré pronto.',
            'Repostería fina de verdad. Los macarons son deliciosos.',
            'Ambiente sofisticado y café de altísima calidad. Muy recomendado.',
            'Me encantó el Affogato, una combinación perfecta.',
            'Atención impecable en la barra de especialidad.'
        ];

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            
            // Generar entre 5 y 12 reservaciones diarias para que el dashboard luzca lleno
            $resCount = rand(5, 12); 

            for ($i = 0; $i < $resCount; $i++) {
                $status = ($date->copy()->isPast()) ? 'finalizada' : 'confirmada';
                $hour = rand(8, 20);
                $horaInicio = Carbon::parse($date->toDateString() . ' ' . sprintf('%02d:00:00', $hour));
                $horaFin = $horaInicio->copy()->addMinutes($cafe->duracion_reserva_min);

                $cliente = $clientNames[array_rand($clientNames)] . ' ' . $lastNames[array_rand($lastNames)];
                
                $r = Reservacion::create([
                    'folio' => 'RSV-' . Str::upper(Str::random(6)),
                    'nombre_cliente' => $cliente,
                    'telefono' => '55' . rand(10000000, 99999999),
                    'email' => strtolower(Str::slug($cliente)) . '@example.com',
                    'fecha' => $date->toDateString(),
                    'hora_inicio' => $horaInicio->format('H:i:s'),
                    'hora_fin' => $horaFin->format('H:i:s'),
                    'numero_personas' => rand(1, 4),
                    'estado' => $status,
                    'cafe_id' => $cafe->id,
                    'zona_id' => $zonas[array_rand($zonas)],
                    'ocasion_especial_id' => (rand(1, 3) === 1) ? $ocasiones[array_rand($ocasiones)] : null,
                    'promocion_id' => (rand(1, 4) === 1) ? $promos[array_rand($promos)] : null,
                ]);

                // Si está finalizada, crear el detalle de ocupación y opcionalmente una reseña
                if ($status === 'finalizada') {
                    $o = \App\Models\DetalleOcupacion::create([
                        'reservacion_id' => $r->id,
                        'cafe_id' => $cafe->id,
                        'user_id' => $staff ? $staff->id : null,
                        'mesa_id' => Mesa::where('cafe_id', $cafe->id)->where('zona_id', $r->zona_id)->inRandomOrder()->first()?->id,
                        'numero_personas' => $r->numero_personas,
                        'tipo' => 'reservacion',
                        'hora_entrada' => $horaInicio->copy()->addMinutes(rand(-5, 5)),
                        'hora_salida' => $horaFin->copy()->addMinutes(rand(0, 20)),
                        'estado' => 'finalizada',
                    ]);

                    // Crear reseña para el 60% de las ocupaciones
                    if (rand(1, 10) <= 6) {
                        \App\Models\Resena::create([
                            'detalle_ocupacion_id' => $o->id,
                            'cafe_id' => $cafe->id,
                            'calificacion' => rand(4, 5), // Siempre buenas calificaciones para la demo ;)
                            'comentario' => $reviews[array_rand($reviews)],
                            'estado' => 'aprobada'
                        ]);
                    }
                }
            }
        }
    }
}
}
