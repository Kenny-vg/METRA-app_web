<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\CafeScope;

class Zona extends Model
{
    //
    protected $fillable = [
        'nombre_zona',
        'activo',
        'cafe_id'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new CafeScope);
    }
    public function cafeteri()
    {
        return $this->belongsTo(Cafeteria::class);
    }
    public function mesas()
    {
        return $this->hasMany(Mesa::class);
    }
}
