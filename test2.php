<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::create('/api/superadmin/cafeterias', 'GET');
$request->headers->set('Accept', 'application/json');

// We need a dummy superadmin token to bypass auth middleware, or better just run the controller.
$response = $kernel->handle($request);
echo $response->getContent();
