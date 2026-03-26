<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\CafeScope;

class MenuCategoria extends Model
{
    protected $table = 'menu_categorias';

    protected $fillable = [
        'nombre',
        'descripcion',
        'orden',
        'activo',
        'cafe_id'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new CafeScope);
    }

    public function cafeteria()
    {
        return $this->belongsTo(Cafeteria::class, 'cafe_id');
    }

    public function menus()
    {
        return $this->hasMany(Menu::class, 'categoria_id');
    }
}
