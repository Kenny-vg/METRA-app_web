<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OcasionEspecial extends Model
{
    //
    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
        'cafe_id'
    ];
    public function cafeteria()
    {
        return $this->belongsTo(Cafeteria::class);
    }
    public function promociones()
    {
        return $this->belongsToMany(
            Promocion::class,
            'ocasion_promocion',
            'ocasion_id',
            'promocion_id'
        );
    }
}
