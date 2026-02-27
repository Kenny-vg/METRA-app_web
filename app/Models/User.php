<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; //Permite crear tokens para API
use App\Models\Cafeteria;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    //campos que se pueden insertar o actualizar
    protected $fillable = [
        'name',
        'ap_paterno',
        'ap_materno',
        'email',
        'password',
        'role',
        'cafe_id',
        'estado',
        'google_id',
        'avatar'
    ];

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
            'estado'=> 'boolean',
        ];
    }

    public function cafeteria()
    {
        return $this->belongsTo(Cafeteria::class, 'cafe_id');
    }
    
}
