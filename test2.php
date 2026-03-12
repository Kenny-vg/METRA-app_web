<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::whereIn('role', ['gerente', 'personal'])->first();

if ($user) {
    echo "User ID: " . $user->id . "\n";
    echo "Role: " . $user->role . "\n";
    echo "Estado: " . $user->estado . "\n";
    echo "Cafeteria ID: " . $user->cafe_id . "\n";
    
    $cafeteria = $user->cafeteria;
    if($cafeteria) {
        echo "Cafeteria Found\n";
        $suscActiva = $cafeteria->suscripciones()
            ->where('estado_pago', 'pagado')
            ->where('fecha_inicio', '<=', now())
            ->where('fecha_fin', '>=', now())
            ->first();
        echo "Has Active Subscription: " . ($suscActiva ? "Yes" : "No") . "\n";
        if($suscActiva) {
            echo "Sub ID: " . $suscActiva->id . "\n";
            echo "Sub Inicio: " . $suscActiva->fecha_inicio . "\n";
            echo "Sub Fin: " . $suscActiva->fecha_fin . "\n";
            echo "Sub Estado Pago: " . $suscActiva->estado_pago . "\n";
        } else {
            $subs = $cafeteria->suscripciones()->get();
            echo "Total Subs: " . $subs->count() . "\n";
            foreach($subs as $sub) {
                echo "- Sub ID: {$sub->id}, Inicio: {$sub->fecha_inicio}, Fin: {$sub->fecha_fin}, Pago: {$sub->estado_pago}\n";
            }
        }
    } else {
        echo "No Cafeteria Found\n";
    }
} else {
    echo "No gerente or personal user found.\n";
}
