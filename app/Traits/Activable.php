<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

trait Activable
{
    public function activar(Request $request, $id)
    {
        $model = $this->model::find($id);

        if (!$model) {
            return ApiResponse::error('Registro no encontrado',404);
        }

        $model->update([
            'activo' => true
        ]);

        return ApiResponse::success($model, 'Registro reactivado correctamente');
    }
}