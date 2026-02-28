<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ConfiguracionSistema extends Model
{
    //
    protected $table = 'configuracion_sistema';

    protected $fillable = [
        'banco',
        'clabe',
        'beneficiario',
        'instrucciones_pago',
        'email_soporte',
        'telefono_soporte',
        'whatsapp_soporte'
    ];
}
