<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;

header('Content-Type: text/plain');

echo "--- DIAGNÓSTICO RAILWAY ---\n\n";

echo "1. Variables de Entorno (Obfuscadas):\n";
$vars = [
    'MAIL_MAILER', 'MAIL_HOST', 'MAIL_PORT', 'MAIL_USERNAME', 
    'MAIL_ENCRYPTION', 'MAIL_FROM_ADDRESS', 'QUEUE_CONNECTION', 'APP_URL'
];
foreach ($vars as $v) {
    $val = env($v, 'NOT SET');
    if (str_contains($v, 'PASSWORD') || str_contains($v, 'USERNAME')) {
        $val = substr($val, 0, 3) . '***';
    }
    echo "$v: $val\n";
}

echo "\n2. Prueba de Conectividad (fsockopen):\n";
$host = env('MAIL_HOST', 'smtp.gmail.com');
$port = env('MAIL_PORT', 587);
$connection = @fsockopen($host, $port, $errno, $errstr, 5);
if (is_resource($connection)) {
    echo "CONECTADO a $host:$port ✅\n";
    fclose($connection);
} else {
    echo "ERROR DE CONEXIÓN a $host:$port ❌\n";
    echo "Error ($errno): $errstr\n";
}

echo "\n3. Prueba de Envío de Mail (Stack Trace):\n";
try {
    Mail::to('test@example.com')->send(new ResetPasswordMail('http://localhost', 'test@example.com'));
    echo "Mail enviado satisfactoriamente! (Check log for real sending) ✅\n";
} catch (\Exception $e) {
    echo "ERROR AL ENVIAR MAIL ❌\n";
    echo "Mensaje: " . $e->getMessage() . "\n";
    echo "Archivo: " . $e->getFile() . " (Línea " . $e->getLine() . ")\n";
    echo "\nSTACK TRACE:\n" . $e->getTraceAsString() . "\n";
}

echo "\n4. Últimas líneas de laravel.log:\n";
$logPath = storage_path('logs/laravel.log');
if (file_exists($logPath)) {
    $lines = array_slice(file($logPath), -20);
    echo implode("", $lines);
} else {
    echo "Archivo de log no encontrado en $logPath\n";
}
