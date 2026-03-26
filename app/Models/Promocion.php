<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\CafeScope;

class Promocion extends Model
{
    //
    protected $fillable = [
        'nombre_promocion',
        'descripcion',
        'precio',
        'fecha_inicio',
        'fecha_fin',
        'hora_inicio',
        'hora_fin',
        'dias_semana',
        'activo',
        'cafe_id'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new CafeScope);
    }
    public function cafeteria()
    {
        return $this->belongsTo(Cafeteria::class);
    }
    public function ocasiones()
    {
        return $this->belongsToMany(
            OcasionEspecial::class ,
            'ocasion_promocion',
            'promocion_id',
            'ocasion_id'
        );
    }
    public function reservaciones()
    {
        return $this->hasMany(Reservacion::class);
    }
}
