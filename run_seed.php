<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--seed' => true]);
    echo "Success\n";
} catch (\Throwable $e) {
    file_put_contents(__DIR__.'/storage/logs/my_error.log', $e->getMessage() . "\n" . $e->getTraceAsString());
    echo "Failed! Error logged to storage/logs/my_error.log\n";
}
