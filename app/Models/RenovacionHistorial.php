<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RenovacionHistorial extends Model
{
    protected $table = 'renovaciones_historial';

    protected $fillable = [
        'cafe_id',
        'suscripcion_id',
        'plan_id',
        'monto',
        'comprobante_url',
        'fecha_inicio_anterior',
        'fecha_fin_anterior',
        'estado_pago_anterior',
        'fecha_solicitud',
    ];

    protected $casts = [
        'fecha_inicio_anterior' => 'datetime',
        'fecha_fin_anterior'    => 'datetime',
        'fecha_solicitud'       => 'datetime',
    ];

    public function cafeteria()
    {
        return $this->belongsTo(Cafeteria::class, 'cafe_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function suscripcion()
    {
        return $this->belongsTo(Suscripcion::class, 'suscripcion_id');
    }
}
