<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    //
    protected $fillable = [
        'dia_semana',
        'hora_apertura',
        'hora_cierre',
        'activo',
        'cafe_id'
    ];
    public function cafeteria()
    {
        return $this->belongsTo(Cafeteria::class, 'cafe_id');
    }


    
}
