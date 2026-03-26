<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\CafeScope;

class Menu extends Model
{
    protected $fillable = [
        'nombre_producto',
        'descripcion',
        'imagen_url',
        'activo',
        'orden',
        'cafe_id',
        'categoria_id'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new CafeScope);
    }

    public function cafeteria()
    {
        return $this->belongsTo(Cafeteria::class,'cafe_id');
    }

    public function categoria()
    {
        return $this->belongsTo(MenuCategoria::class, 'categoria_id');
    }

    public function getImagenUrlAttribute($value)
    {
        if (!$value) {
            return null;
        }

        return asset('storage/'.$value);
    }
}
