<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'nombre_producto',
        'descripcion',
        'imagen_url',
        'activo',
        'cafe_id'
    ];

    public function cafeteria()
    {
        return $this->belongsTo(Cafeteria::class,'cafe_id');
    }

    public function getImagenUrlAttribute($value)
    {
        if (!$value) {
            return null;
        }

        return asset('storage/'.$value);
    }
}
