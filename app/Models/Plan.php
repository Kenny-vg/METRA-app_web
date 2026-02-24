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
        'estado'
    ];

    public function suscripciones()
    {
        return $this->hasMany(Suscripcion::class);
    }

}
