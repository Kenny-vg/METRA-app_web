<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\CafeScope;
use App\Services\CloudinaryService;

class Menu extends Model
{
    protected $fillable = [
        'nombre_producto',
        'descripcion',
        'imagen_url',
        'imagen_public_id',
        'precio',
        'activo',
        'orden',
        'cafe_id',
        'categoria_id'
    ];
    protected $appends = ['imagen_full_url'];

    protected static function booted()
    {
        static::addGlobalScope(new CafeScope);

        // Limpiar Cloudinary al eliminar registro
        static::deleting(function ($menu) {
            if ($menu->imagen_public_id) {
                CloudinaryService::delete($menu->imagen_public_id);
            }
        });
    }

    public function cafeteria()
    {
        return $this->belongsTo(Cafeteria::class,'cafe_id');
    }

    public function categoria()
    {
        return $this->belongsTo(MenuCategoria::class, 'categoria_id');
    }

    public function getImagenFullUrlAttribute()
    {
        return $this->attributes['imagen_url'] ?? null;
    }
}
