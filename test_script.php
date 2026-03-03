<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$request = Illuminate\Http\Request::create('/api/registro-negocio', 'POST', [
    'nombre' => 'Cafe Test',
    'gerente' => [
        'name' => 'G',
        'email' => 'test@g.com',
        'password' => 'password123',
        'password_confirmation' => 'password123'
    ],
    'plan_id' => 1
]);

$request->headers->set('Accept', 'application/json');

$response = app()->handle($request);
echo $response->getContent();
