<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suscripcion extends Model
{
    //

    protected $table = 'suscripciones';

    protected $fillable = [
        'cafe_id',
        'plan_id',
        'fecha_inicio',
        'fecha_fin',
        'estado_pago',
        'monto',
        'comprobante_url',
        'comprobante_public_id',
        'user_id',
        'fecha_validacion',
        'en_revision',
    ];




    //relaciones
    public function cafeteria(){
        return $this->belongsTo(Cafeteria::class, 'cafe_id');
    }
    public function plan(){
        return $this->belongsTo(Plan::class, 'plan_id');
    }
    public function usuario(){
        return $this->belongsTo(User::class,'user_id');
    }
}
