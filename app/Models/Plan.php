<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    //
    protected $table = 'planes';
    protected $fillable = [
        'nombre_plan',
        'precio',
        'duracion_dias',
        'max_reservas_mes',
        'max_usuarios_admin',
        'descripcion',
        'estado',
        'tiene_metricas_avanzadas',
        'tiene_recordatorios',
    ];

    protected $casts = [
        'tiene_metricas_avanzadas' => 'boolean',
        'tiene_recordatorios'     => 'boolean',
        'estado'                  => 'boolean',
    ];

    public function suscripciones()
    {
        return $this->hasMany(Suscripcion::class);
    }

}
