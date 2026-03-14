<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\CafeScope;

class DetalleOcupacion extends Model
{
    protected $table = 'detalle_ocupaciones';

    protected $fillable = [
        'comentarios',
        'hora_entrada',
        'hora_salida',
        'estado',
        'reservacion_id',
        'cafe_id',
        'user_id',
        'mesa_id'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new CafeScope);
    }

    public function cafeteria()
    {
        return $this->belongsTo(Cafeteria::class, 'cafe_id');
    }

    public function reservacion()
    {
        return $this->belongsTo(Reservacion::class, 'reservacion_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mesa()
    {
        return $this->belongsTo(Mesa::class, 'mesa_id');
    }

    public function resena()
    {
        return $this->hasOne(Resena::class, 'detalle_ocupacion_id');
    }
}
