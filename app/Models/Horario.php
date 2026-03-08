<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\CafeScope;

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

    protected static function booted()
    {
        static::addGlobalScope(new CafeScope);
    }
    public function cafeteria()
    {
        return $this->belongsTo(Cafeteria::class, 'cafe_id');
    }


    
}
