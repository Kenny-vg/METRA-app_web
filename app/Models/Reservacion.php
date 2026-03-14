<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'id_usuario',
        'id_cafeteria',
        'id_ocasion',
        'id_promocion'
    ];

    // Usuario que hizo la reservación
    public function usuario()
    {
        return $this->belongsTo(User::class , 'id_usuario');
    }

    // Cafetería donde se hace la reservación
    public function cafeteria()
    {
        return $this->belongsTo(Cafeteria::class , 'id_cafeteria');
    }

    // Ocasión especial de la reservación
    public function ocasion()
    {
        return $this->belongsTo(OcasionEspecial::class , 'id_ocasion');
    }

    //Promocion de la reservacion
    public function promocion()
    {
        return $this->belongsTo(Promocion::class , 'id_promocion');
    }

    //Ocupacion de la reservacion
    public function detalleOcupacion()
    {
        return $this->hasOne(DetalleOcupacion::class , 'reservacion_id');
    }
}
