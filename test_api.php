<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::create(
        '/api/login', 'POST', [
            'email' => 'gerente@test.com', // Need to find a valid user
            'password' => 'password'
        ]
    )
);
echo $response->getContent();
