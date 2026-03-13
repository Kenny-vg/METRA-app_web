<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CheckUserCommand extends Command
{
    protected $signature = 'check:user';
    protected $description = 'Check user data';

    public function handle()
    {
        $user = User::where('role', 'personal')->orderBy('id', 'desc')->first();
        if (!$user) {
            $this->info("No staff users found.");
            return;
        }

        $this->info("=== 1. USER DATA (Last added staff) ===");
        $this->info("User ID: {$user->id}");
        $this->info("Name: {$user->name}");
        $this->info("Email: {$user->email}");
        $this->info("Role: {$user->role} (Expected: 'personal')");
        $this->info("Estado: {$user->estado} (Expected: 1/true)");
        $this->info("Cafe ID: {$user->cafe_id} (Expected: Int > 0)");

        $cafeteria = $user->cafeteria;
        $nombre = $cafeteria ? ($cafeteria->nombre_cafeteria ?? $cafeteria->nombre ?? 'N/A') : 'N/A';
        
        $this->info("\n=== 2. CAFETERIA RELATION ===");
        $this->info("Cafeteria loaded via relationship: " . ($cafeteria ? "Yes, ID: {$cafeteria->id}, Nombre: {$nombre}" : 'No (NULL)'));

        if ($cafeteria) {
            $suscripcionActiva = $cafeteria->suscripciones()
                    ->where('estado_pago','pagado')
                    ->where('fecha_inicio','<=',now())
                    ->where('fecha_fin','>=',now())
                    ->first();
            $this->info("\n=== 3. SUBSCRIPTION CHECK ===");
            $this->info("Active Subscription query matched (pagado, active dates): " . ($suscripcionActiva ? "Yes, ID: {$suscripcionActiva->id}" : 'No'));

            $todas = $cafeteria->suscripciones()->get();
            $this->info("\nAll Subscriptions for this Cafeteria (Count: " . $todas->count() . "):");
            foreach($todas as $sub) {
                $this->info(" - Sub ID: {$sub->id}");
                $this->info("   Estado Pago: {$sub->estado_pago} (Expected: 'pagado')");
                $this->info("   Inicio: {$sub->fecha_inicio}");
                $this->info("   Fin: {$sub->fecha_fin}");
            }
            $this->info("\nCurrent Server Time (now()): " . now());

            $this->info("\n=== 4. MIDDLEWARE DIAGNOSIS ===");
            if (!$user->estado) {
                $this->info("-> Fails at RoleMiddleware ('Usuario inactivo')");
            } elseif ($user->role !== 'personal') {
                $this->info("-> Fails at RoleMiddleware ('No autorizado')");
            } elseif (!$cafeteria) {
                $this->info("-> Fails at CheckSuscripcionActiva ('No tienes una cafetería asociada.')");
            } elseif (!$suscripcionActiva) {
                $this->info("-> Fails at CheckSuscripcionActiva ('Tu suscripción ha expirado. Renueva para continuar.')");
            } else {
                $this->info("-> No errors detected based on the database state! If 403 happens, it's somewhere else.");
            }
        } else {
            $this->info("\n=== 4. MIDDLEWARE DIAGNOSIS ===");
            $this->info("-> Fails at CheckSuscripcionActiva ('No tienes una cafetería asociada.')");
        }
    }
}
