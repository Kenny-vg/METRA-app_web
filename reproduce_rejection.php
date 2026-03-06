<?php

use App\Models\User;
use App\Models\Cafeteria;
use App\Models\Suscripcion;
use App\Models\Plan;
use Illuminate\Support\Facades\Hash;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// 1. Setup dummy data
$email = 'test_rechazo@example.com';
$user = User::where('email', $email)->first();
if ($user) {
    $user->cafeteria()->delete();
    $user->delete();
}

$plan = Plan::first();
if (!$plan) {
    echo "No hay planes en la DB. Abortando.\n";
    exit;
}

$cafeteria = Cafeteria::create([
    'nombre' => 'Cafe Test Rechazo',
    'estado' => 'en_revision'
]);

$user = User::create([
    'name' => 'Gerente Test',
    'email' => $email,
    'password' => Hash::make('password123'),
    'role' => 'gerente',
    'cafe_id' => $cafeteria->id,
    'estado' => 0,
    'estatus_registro' => 'pendiente'
]);

$cafeteria->update(['user_id' => $user->id]);

$suscripcion = Suscripcion::create([
    'cafe_id' => $cafeteria->id,
    'plan_id' => $plan->id,
    'user_id' => $user->id,
    'fecha_inicio' => now(),
    'fecha_fin' => now()->addDays(30),
    'estado_pago' => 'pendiente',
    'monto' => $plan->precio,
    'comprobante_url' => 'test/path.png'
]);

echo "--- ESCENARIO: PENDIENTE ---\n";
testLogin($email, 'password123');

// 2. Simulate Rejection
echo "\n--- SIMULANDO RECHAZO ---\n";
$cafeteria->update(['estado' => 'suspendida']);
$user->update(['estado' => 0, 'estatus_registro' => 'rechazado']);
$suscripcion->update(['estado_pago' => 'cancelado']);

echo "--- ESCENARIO: RECHAZADO ---\n";
testLogin($email, 'password123');

function testLogin($email, $password) {
    $request = Illuminate\Http\Request::create('/api/login', 'POST', [
        'email' => $email,
        'password' => $password
    ]);

    $controller = app(App\Http\Controllers\Api\Auth\LoginController::class);
    $response = $controller->login($request);

    echo "Status: " . $response->getStatusCode() . "\n";
    echo "Body: " . $response->getContent() . "\n";
}
