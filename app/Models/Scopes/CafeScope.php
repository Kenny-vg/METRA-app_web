<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class CafeScope implements Scope
{
    /**
     * Aplica filtro automático por cafetería
     */
    public function apply(Builder $builder, Model $model): void
    {
        // Fuerza la resolución segura del usuario desde Auth facade o Request actual
        $user = auth()->user() ?? request()->user();

        if(!$user){
            return;
        }

        // Solo filtrar si el usuario pertenece a una cafetería (gerente o personal)
        // Esto evita que clientes o invitados vean sus consultas filtradas por cafe_id = null
        if (in_array($user->role, ['gerente', 'personal'])) {
            $builder->where(
                $model->getTable().'.cafe_id',
                $user->cafe_id
            );
        }
    }
}
