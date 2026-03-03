<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Cafeteria;
use App\Models\Suscripcion;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

// Clean up previous test data if any
User::whereIn('email', ['testA@test.com', 'testB@test.com', 'testC@test.com'])->delete();
Cafeteria::whereIn('nombre', ['Cafe Test A', 'Cafe Test B', 'Cafe Test C'])->delete();

echo "\n--- Creating Test Data ---\n";

// Caso A: Sin comprobante
$userA = User::create(['email' => 'testA@test.com', 'name' => 'Test User A', 'password' => Hash::make('password123'), 'role' => 'gerente', 'estado' => false]);
$cafeA = Cafeteria::create(['nombre' => 'Cafe Test A', 'calle' => 'Test', 'num_exterior' => '1', 'colonia' => 'Test', 'ciudad' => 'Test', 'estado_republica' => 'Test', 'cp' => '12345', 'telefono' => '1234567890', 'estado' => false]);
$userA->update(['cafe_id' => $cafeA->id]);
Suscripcion::create(['cafeteria_id' => $cafeA->id, 'plan_id' => 1, 'comprobante_url' => null, 'estado_pago' => 'pendiente']);

// Caso B: Con comprobante, pendiente
$userB = User::create(['email' => 'testB@test.com', 'name' => 'Test User B', 'password' => Hash::make('password123'), 'role' => 'gerente', 'estado' => false]);
$cafeB = Cafeteria::create(['nombre' => 'Cafe Test B', 'calle' => 'Test', 'num_exterior' => '1', 'colonia' => 'Test', 'ciudad' => 'Test', 'estado_republica' => 'Test', 'cp' => '12345', 'telefono' => '1234567890', 'estado' => false]);
$userB->update(['cafe_id' => $cafeB->id]);
Suscripcion::create(['cafeteria_id' => $cafeB->id, 'plan_id' => 1, 'comprobante_url' => 'test.jpg', 'estado_pago' => 'pendiente']);

// Caso C: Aprobado
$userC = User::create(['email' => 'testC@test.com', 'name' => 'Test User C', 'password' => Hash::make('password123'), 'role' => 'gerente', 'estado' => true]);
$cafeC = Cafeteria::create(['nombre' => 'Cafe Test C', 'calle' => 'Test', 'num_exterior' => '1', 'colonia' => 'Test', 'ciudad' => 'Test', 'estado_republica' => 'Test', 'cp' => '12345', 'telefono' => '1234567890', 'estado' => true]);
$userC->update(['cafe_id' => $cafeC->id]);
Suscripcion::create(['cafeteria_id' => $cafeC->id, 'plan_id' => 1, 'comprobante_url' => 'test.jpg', 'estado_pago' => 'aprobado', 'fecha_fin' => now()->addDays(30)]);

echo "Test users created.\n";
