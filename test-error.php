<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create('/api/superadmin/cafeterias', 'GET');
$request->headers->set('Accept', 'application/json');
$response = $kernel->handle($request);
file_put_contents('error_output.json', $response->getContent());
