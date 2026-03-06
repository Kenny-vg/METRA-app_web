<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    //
    protected $fillable = [
        'nombre_promocion',
        'descripcion',
        'precio',
        'activo',
        'cafe_id'
    ];
    public function cafeteria()
    {
        return $this->belongsTo(Cafeteria::class);
    }
    public function ocasiones()
    {
        return $this->belongsToMany(
            OcasionEspecial::class, 
            'ocasion_promocion',
            'promocion_id',
            'ocasion_id'
        );
    }
}
