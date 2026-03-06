<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    //
    protected $fillable = [
        'numero_mesa',
        'capacidad',
        'ubicacion',
        'activo',
        'zona_id',
        'cafe_id'
    ];
    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }
    public function cafeteria()
    {
        return $this->belongsTo(Cafeteria::class);
    }
}
