<?php

use App\Models\User;
use App\Models\Cafeteria;
use App\Models\Suscripcion;
use App\Models\Plan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\CuentaRechazadaMail;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

Mail::fake();

// Setup
$email = 'flow_test@example.com';
$user = User::where('email', $email)->first();
if ($user) {
    if($user->cafeteria) $user->cafeteria->delete();
    $user->delete();
}

$plan = Plan::where('estado', 1)->first();
if (!$plan) {
    echo "No hay planes activos. Abortando.\n";
    exit;
}

echo "--- ESCENARIO 1: Registro Nuevo ---\n";
$payload = [
    'nombre' => 'Cafe Flow Test',
    'calle' => 'Calle 1',
    'num_exterior' => '123',
    'colonia' => 'Centro',
    'ciudad' => 'Tehuacan',
    'estado_republica' => 'Puebla',
    'cp' => '75700',
    'telefono' => '1234567890',
    'gerente' => [
        'name' => 'Gerente Flow',
        'email' => $email,
        'password' => 'password123',
        'password_confirmation' => 'password123'
    ],
    'plan_id' => $plan->id
];

$response1 = callStore($payload);
echo "Status: " . $response1->getStatusCode() . "\n";
echo "Body: " . $response1->getContent() . "\n";

$data1 = json_decode($response1->getContent(), true);
$cafeteriaId = $data1['data']['cafeteria_id'] ?? null;

echo "\n--- ESCENARIO 2: Registro Duplicado Pendiente ---\n";
$response2 = callStore($payload);
echo "Status: " . $response2->getStatusCode() . "\n";
echo "Body: " . $response2->getContent() . "\n";

echo "\n--- ESCENARIO 4a: Subir Comprobante ---\n";
$response3 = callSubir($cafeteriaId);
echo "Status: " . $response3->getStatusCode() . "\n";
echo "Body: " . $response3->getContent() . "\n";

echo "\n--- ESCENARIO 4b: Subir Comprobante DUPLICADO ---\n";
$response4 = callSubir($cafeteriaId);
echo "Status: " . $response4->getStatusCode() . "\n";
echo "Body: " . $response4->getContent() . "\n";

echo "\n--- ESCENARIO 5: Intentar modificar después de subir ---\n";
$response5 = callStore($payload);
echo "Status: " . $response5->getStatusCode() . "\n";
echo "Body: " . $response5->getContent() . "\n";

echo "\n--- ESCENARIO 3: Registro con correo RECHAZADO ---\n";
// Rechazar manualmente
$user = User::where('email', $email)->first();
$user->update(['estatus_registro' => 'rechazado']);
$user->cafeteria->update(['estado' => 'suspendida']);

$response6 = callStore($payload);
echo "Status: " . $response6->getStatusCode() . "\n";
echo "Body: " . $response6->getContent() . "\n";

echo "\n--- ESCENARIO EXTRA: Probar Mailable Integration ---\n";
$controller = app(App\Http\Controllers\Api\Superadmin\AprobacionController::class);
$controller->rechazar($user->cafeteria);
Mail::assertQueued(CuentaRechazadaMail::class, function ($mail) use ($email) {
    return $mail->hasTo($email);
});
echo "Mail::queue(CuentaRechazadaMail) verificado.\n";


function callStore($payload) {
    $request = Illuminate\Http\Request::create('/api/registro-negocio', 'POST', $payload);
    $controller = app(App\Http\Controllers\Api\RegistroNegocioController::class);
    return $controller->store($request);
}

function callSubir($id) {
    if(!$id) return new Illuminate\Http\Response('No ID', 400);
    $file = Illuminate\Http\UploadedFile::fake()->create('comprobante.png', 100);
    $request = Illuminate\Http\Request::create("/api/registro-negocio/$id/comprobante", 'POST');
    $request->files->set('comprobante', $file);
    $controller = app(App\Http\Controllers\Api\RegistroNegocioController::class);
    $cafeteria = Cafeteria::find($id);
    return $controller->subirComprobante($request, $cafeteria);
}
