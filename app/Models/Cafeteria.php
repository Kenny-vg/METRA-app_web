<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cafeteria extends Model
{
    protected $table = 'cafeterias';
    protected $fillable = [
        'nombre',
        'slug',
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
        'duracion_reserva_min',
        'intervalo_reserva_min',
        'porcentaje_reservas'
    ];

    protected $appends = ['estado_dinamico'];

    protected static function booted()
    {
        static::creating(function ($cafeteria) {
            if (empty($cafeteria->slug)) {
                $cafeteria->slug = \Illuminate\Support\Str::slug($cafeteria->nombre);
            }
        });

        static::updating(function ($cafeteria) {
            if ($cafeteria->isDirty('nombre') && empty($cafeteria->slug)) {
                $cafeteria->slug = \Illuminate\Support\Str::slug($cafeteria->nombre);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

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

    // Horarios de la cafetería
    public function horarios()
    {
        return $this->hasMany(Horario::class, 'cafe_id');
    }

    // Mesas de la cafetería
    public function mesas()
    {
        return $this->hasMany(Mesa::class, 'cafe_id');
    }

    public function suscripcionActual()
    {
        return $this->hasOne(Suscripcion::class, 'cafe_id')
            ->where('fecha_fin', '>=', now()->startOfDay())
            ->latest('fecha_fin');
    }

    public function ultimaSuscripcion()
    {
        return $this->hasOne(Suscripcion::class, 'cafe_id')->latest('id');
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

    public function getEstadoDinamicoAttribute()
    {
        return $this->getEstadoAttribute($this->attributes['estado'] ?? 'activa');
    }

    public function getEstadoAttribute($value)
    {
        // Solo sobreescribimos si el estado en base de datos es activa y la suscripcion ya venció
        if ($value === 'activa') {
            // Evaluamos primero si tiene pago pendiente de validación
            $tienePendiente = $this->suscripciones()
                ->where('estado_pago', 'pendiente')
                ->exists();
                
            if ($tienePendiente) {
                return 'pendiente';
            }
            
            // Buscamos si tiene ALGUNA suscripción pagada y activa el día de hoy
            $tieneActiva = $this->suscripciones()
                ->where('estado_pago', 'pagado')
                ->where('fecha_inicio', '<=', now()->endOfDay())
                ->where('fecha_fin', '>=', now()->startOfDay())
                ->exists();
                
            if (!$tieneActiva) {
                return 'vencida';
            }
        }
        return $value;
    }

    public function planActivo()
    {
        return $this->suscripcionActual()->first()?->plan;
    }
}
