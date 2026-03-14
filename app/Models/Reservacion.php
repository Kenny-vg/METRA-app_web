<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\CafeScope;

class Reservacion extends Model
{
    protected $table = 'reservaciones';

    protected $fillable = [
        'folio',
        'nombre_cliente',
        'telefono',
        'email',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'numero_personas',
        'estado',
        'tipo',
        'comentarios',
        'user_id',
        'cafe_id',
        'ocasion_especial_id',
        'promocion_id'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new CafeScope);
    }

    // Usuario que hizo la reservación
    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }

    // Cafetería donde se hace la reservación
    public function cafeteria()
    {
        return $this->belongsTo(Cafeteria::class , 'cafe_id');
    }

    // Ocasión especial de la reservación
    public function ocasionEspecial()
    {
        return $this->belongsTo(OcasionEspecial::class , 'ocasion_especial_id');
    }

    //Promocion de la reservacion
    public function promocion()
    {
        return $this->belongsTo(Promocion::class , 'promocion_id');
    }

    //Ocupacion de la reservacion
    public function detalleOcupacion()
    {
        return $this->hasOne(DetalleOcupacion::class , 'reservacion_id');
    }
}
