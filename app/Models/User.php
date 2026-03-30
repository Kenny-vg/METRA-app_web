<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; //Permite crear tokens para API
use App\Models\Cafeteria;
use App\Models\Scopes\CafeScope;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    //campos que se pueden insertar o actualizar
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'cafe_id',
        'estado',
        'google_id',
        'avatar',
        'activation_token',
        'estatus_registro',
    ];
    protected $appends = ['avatar_full_url'];

    //campos que no se devuelven en respuestas JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'estado' => 'boolean',
        ];
    }

    protected static function booted()
    {
        static::addGlobalScope(new CafeScope);
    }


    public function cafeteria()
    {
        return $this->belongsTo(Cafeteria::class , 'cafe_id');
    }

    public function getAvatarFullUrlAttribute()
    {
        $value = $this->attributes['avatar'] ?? null;
        if (!$value) {
            return null;
        }

        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        return asset('storage/' . $value);
    }
}
