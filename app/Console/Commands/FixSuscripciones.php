<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Suscripcion;
use App\Models\RenovacionHistorial;
use Illuminate\Support\Facades\DB;

class FixSuscripciones extends Command
{
    protected $signature = 'metra:renovaciones-historial-migrar';
    protected $description = 'Limpia registros duplicados en suscripciones y migra el pasado a renovaciones_historial.';

    public function handle()
    {
        $this->info('Iniciando migración de historial de suscripciones...');
        
        // 1. Encontrar todas las cafeterias que tienen suscripciones
        $cafeterias = Suscripcion::select('cafe_id')->distinct()->pluck('cafe_id');
        $migrados = 0;
        
        DB::beginTransaction();
        try {
            foreach ($cafeterias as $cafeId) {
                // Obtener todas las suscripciones de la cafetería ordenadas cronológicamente
                $suscripciones = Suscripcion::where('cafe_id', $cafeId)
                                            ->orderBy('created_at', 'asc')
                                            ->get();
                
                if ($suscripciones->count() <= 1) {
                    continue; // Solo tiene 1 registro, es la suscripción actual, no hay historial que migrar
                }

                // El último registro es la suscripción actual en vigencia o pendiente de aprobar
                $latest = $suscripciones->last();
                
                // Los registros anteriores son históricos, los pasamos a la nueva tabla
                foreach ($suscripciones as $s) {
                    if ($s->id === $latest->id) continue;
                    
                    // Mover al historial
                    RenovacionHistorial::firstOrCreate(
                        [
                            'cafe_id' => $s->cafe_id,
                            'suscripcion_id' => $latest->id,
                            'plan_id' => $s->plan_id,
                            'monto' => $s->monto,
                            'comprobante_url' => $s->comprobante_url,
                            'fecha_inicio_anterior' => $s->fecha_inicio,
                            'fecha_fin_anterior' => $s->fecha_fin,
                            'estado_pago_anterior' => $s->estado_pago,
                            'fecha_solicitud' => $s->created_at,
                            'created_at' => $s->created_at,
                            'updated_at' => $s->updated_at,
                        ]
                    );
                    
                    // Eliminar el registro duplicado antiguo de la tabla principal
                    $s->delete();
                    $migrados++;
                }
            }
            DB::commit();
            $this->info("¡Éxito! Migración completada. Se movieron {$migrados} registros históricos a renovaciones_historial y se eliminaron de la tabla principal.");
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Ocurrió un error en la migración: " . $e->getMessage());
        }
    }
}
