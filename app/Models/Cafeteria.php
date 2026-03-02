<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cafeteria extends Model
{
    protected $table = 'cafeterias';
    protected $fillable = [
        'nombre',
        'descripcion',
        'calle',
        'num_exterior',
        'num_interior',
        'colonia',
        'ciudad',
        'estado_republica',
        'cp',
        'telefono',
        'estado',
        'foto_url',
        'user_id',
        'comprobante_url',
    ];

    // Gerente/dueño que registró la cafetería
    public function gerente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Suscripción activa o pendiente
    public function suscripciones()
    {
        return $this->hasMany(Suscripcion::class, 'cafe_id');
    }

    public function suscripcionActual()
    {
        return $this->hasOne(Suscripcion::class, 'cafe_id')
            ->where('fecha_fin', '>', now())
            ->latest('fecha_fin');
    }

    public function getComprobanteFullUrlAttribute()
    {
        $value = $this->attributes['comprobante_url'] ?? null;

        return $value
            ? url('/api/admin/comprobante/' . $this->id)
            : null;
    }

    public function getFotoFullUrlAttribute()
    {
        $value = $this->attributes['foto_url'] ?? null;

        return $value
            ? asset('storage/' . $value)
            : null;
}
}
