<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\CafeScope;

class Mesa extends Model
{
    //
    protected $fillable = [
        'numero_mesa',
        'capacidad',
        'activo',
        'zona_id',
        'cafe_id'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new CafeScope);
    }
    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }
    public function cafeteria()
    {
        return $this->belongsTo(Cafeteria::class);
    }
}
