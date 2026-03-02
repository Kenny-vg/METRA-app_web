<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Cafeteria;

$id = 15;
$cafeteria = Cafeteria::find($id);

if ($cafeteria) {
    echo "ID: " . $cafeteria->id . "\n";
    echo "Nombre: " . $cafeteria->nombre . "\n";
    echo "Comprobante URL: " . $cafeteria->comprobante_url . "\n";
} else {
    echo "Cafeteria with ID $id not found.\n";
}
