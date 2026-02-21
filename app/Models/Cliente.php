<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Cliente extends Authenticatable
{
    use HasApiTokens;

    protected $primaryKey = 'id_cliente';
    protected $fillable = [
        'nombre',
        'ap_paterno',
        'ap_materno',
        'correo',
        'password',
        'telefono'
    ];

    protected $hidden = [
        'password'
    ];

}
