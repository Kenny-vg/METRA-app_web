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
        if(!Auth::check()){
            return;
        }
    
        //usuario logueado
        $user = Auth::user();

        //solo filtrar si hay usuario y no es superadmin
        if($user && $user->role !=='superadmin'){
            $builder->where(
                $model->getTable().'.cafe_id',
                $user->cafe_id
            );
        }
    }
}
