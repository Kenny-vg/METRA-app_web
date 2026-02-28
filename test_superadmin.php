<?php
// Script to test Superadmin APIs
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\PlanDeSuscripcion;
use App\Models\Cafeteria;

// Get superadmin
$superadmin = User::where('role', 'superadmin')->first();
if (!$superadmin) {
    die("No superadmin found\n");
}
$token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($superadmin);

$baseUrl = config('app.url') . '/api';

function makeRequest($method, $url, $token, $data = null) {
    echo "====================================\n";
    echo "TESTING: $method $url\n";
    $ch = curl_init($url);
    $headers = [
        'Authorization: Bearer ' . $token,
        'Accept: application/json',
        'Content-Type: application/json'
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, 1);
        if ($data) curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    } else if ($method === 'PUT' || $method === 'PATCH' || $method === 'DELETE') {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if ($data) curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    echo "HTTP Status: $httpCode\n";
    if ($httpCode >= 400) {
        echo "RESPONSE: $response\n";
    } else {
        echo "RESPONSE: (Success) " . substr($response, 0, 100) . "...\n";
    }
    return ['status' => $httpCode, 'response' => $response];
}

// 1. Planes API
echo "\n--- PLANES API TEST ---\n";
// GET planes
makeRequest('GET', "$baseUrl/superadmin/planes", $token);

// POST plane
$postData = [
    'nombre_plan' => 'Test Plan ' . time(),
    'max_reservas_mes' => 10,
    'max_usuarios_admin' => 2,
    'precio' => 100.00,
    'duracion_dias' => 30,
    'descripcion' => 'Plan de prueba'
];
$res = makeRequest('POST', "$baseUrl/superadmin/planes", $token, $postData);
$createdPlanId = null;
if ($res['status'] == 201 || $res['status'] == 200) {
    $json = json_decode($res['response'], true);
    if(isset($json['data']['id'])) {
        $createdPlanId = $json['data']['id'];
    } elseif(isset($json['plan']['id'])) {
        $createdPlanId = $json['plan']['id'];
    }
}

// PUT plane
if ($createdPlanId) {
    $putData = $postData;
    $putData['max_reservas_mes'] = 20;
    makeRequest('PUT', "$baseUrl/superadmin/planes/$createdPlanId", $token, $putData);

    // DELETE plane
    makeRequest('DELETE', "$baseUrl/superadmin/planes/$createdPlanId", $token);
} else {
    echo "Skipping PUT/DELETE planes due to missing ID from POST.\n";
}

// 2. Dashboard / Cafeterias API
echo "\n--- DASHBOARD / CAFETERIAS API TEST ---\n";
makeRequest('GET', "$baseUrl/superadmin/cafeterias", $token);
makeRequest('GET', "$baseUrl/superadmin/solicitudes", $token);

// Aprobar/Rechazar requires an existing "pendiente" cafeteria
$pendiente = Cafeteria::where('estado', 'pendiente')->orderBy('id', 'desc')->first();
if ($pendiente) {
    $id = $pendiente->id;
    makeRequest('PATCH', "$baseUrl/superadmin/cafeterias/$id/aprobar", $token);
    // Since it's approved, let's revert it back to test reject, or just find another
    $pendiente2 = Cafeteria::where('estado', 'pendiente')->orderBy('id', 'desc')->first();
    if ($pendiente2 && $pendiente2->id != $id) {
        makeRequest('PATCH', "$baseUrl/superadmin/cafeterias/{$pendiente2->id}/rechazar", $token);
    }
} else {
    echo "No pending cafeterias found to test Aprobar/Rechazar.\n";
}

echo "\nTests finished.\n";
