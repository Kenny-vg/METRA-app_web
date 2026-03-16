<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\CafeScope;

class Resena extends Model
{
    protected $fillable = [
        'detalle_ocupacion_id',
        'cafe_id',
        'calificacion',
        'comentario',
        'estado'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new CafeScope);
    }

    public function cafeteria()
    {
        return $this->belongsTo(Cafeteria::class , 'cafe_id');
    }

    public function detalleOcupacion()
    {
        return $this->belongsTo(DetalleOcupacion::class , 'detalle_ocupacion_id');
    }
}
