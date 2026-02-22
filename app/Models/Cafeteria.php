<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cafeteria extends Model
{
    //
    protected $table = 'cafeterias';
    protected $fillable =[
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
        'foto_url'
    ];
}
