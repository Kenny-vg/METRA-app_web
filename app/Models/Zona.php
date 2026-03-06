<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    //
    protected $fillable = [
        'nombre_zona',
        'activo',
        'cafe_id'
    ];
    public function cafeteri()
    {
        return $this->belongsTo(Cafeteria::class);
    }
    public function mesas()
    {
        return $this->hasMany(Mesa::class);
    }
}
