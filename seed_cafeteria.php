<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$cafeteria = \App\Models\Cafeteria::create([
    'nombre' => 'Café Central',
    'descripcion' => 'Café de especialidad en el centro de la ciudad.',
    'estado' => 'activa',
    'user_id' => 2, // Gerente Test
]);

$user = \App\Models\User::find(2);
$user->cafe_id = $cafeteria->id;
$user->save();

Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'SuscripcionActivaSeeder']);
echo "Cafeteria and Subscription created.\n";
