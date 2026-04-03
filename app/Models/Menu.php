<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\CafeScope;
use Illuminate\Support\Facades\Storage;

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
                app(\App\Services\CloudinaryService::class)->delete($menu->imagen_public_id);
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
        if (!$this->imagen_url) return null;
        return str_starts_with($this->imagen_url, 'http') ? $this->imagen_url : asset('storage/' . $this->imagen_url);
    }
}
