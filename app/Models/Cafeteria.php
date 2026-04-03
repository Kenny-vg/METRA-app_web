<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'foto_public_id',
        'user_id',
        'comprobante_url',
        'comprobante_public_id',
        'duracion_reserva_min',
        'intervalo_reserva_min',
        'porcentaje_reservas',
        'tolerancia_reserva_min'
    ];

    protected $appends = ['estado_dinamico', 'foto_full_url', 'comprobante_full_url', 'plan_activo'];

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

        // Limpiar Cloudinary al eliminar registro
        static::deleting(function ($cafeteria) {
            $cloudinary = app(\App\Services\CloudinaryService::class);

            if ($cafeteria->foto_public_id) {
                $cloudinary->delete($cafeteria->foto_public_id);
            }
            if ($cafeteria->comprobante_public_id) {
                $cloudinary->delete($cafeteria->comprobante_public_id, 'image', 'authenticated');
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
            ->where('estado_pago', 'pagado')
            ->where('fecha_fin', '>=', now()->startOfDay())
            ->latest('fecha_fin');
    }

    public function ultimaSuscripcion()
    {
        return $this->hasOne(Suscripcion::class, 'cafe_id')->latest('id');
    }

    public function getComprobanteFullUrlAttribute()
    {
        if (!$this->comprobante_url) return null;
        return str_starts_with($this->comprobante_url, 'http') ? $this->comprobante_url : asset('storage/' . $this->comprobante_url);
    }

    public function getFotoFullUrlAttribute()
    {
        if (!$this->foto_url) return null;
        return str_starts_with($this->foto_url, 'http') ? $this->foto_url : asset('storage/' . $this->foto_url);
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

    public function getPlanActivoAttribute()
    {
        return $this->suscripcionActual()->first()?->plan;
    }
}
