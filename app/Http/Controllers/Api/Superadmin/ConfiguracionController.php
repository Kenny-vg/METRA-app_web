<?php

namespace App\Http\Controllers\Api\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    //
    // SUPERADMIN - crear o actualizar
    public function update(Request $request)
    {
        $data = $request->validate([
            'banco' => 'nullable|string',
            'clabe' => 'nullable|string',
            'beneficiario' => 'nullable|string',
            'instrucciones_pago' => 'nullable|string',

            'email_soporte' => 'nullable|email',
            'telefono_soporte' => 'nullable|string',
            'whatsapp_soporte' => 'nullable|string',
        ]);

        $config = ConfiguracionSistema::firstOrCreate();

        if (!$config) {
            $config = ConfiguracionSistema::create($data);
        } else {
            $config->update($data);
        }

        return ApiResponse::success(
            $config,
            'Configuración actualizada correctamente'
        );
    }

    // PUBLICO - para frontend
    public function showPublic()
    {
        return ApiResponse::success(
            ConfiguracionSistema::query()->first(),
            'Configuración del sistema'
        );
    }
}
