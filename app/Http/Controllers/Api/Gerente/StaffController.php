<?php

namespace App\Http\Controllers\Api\Gerente;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Suscripcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Helpers\ApiResponse;

use App\Traits\Activable;

class StaffController extends Controller
{
    use Activable;
    protected $model = User::class;

    /**
     * LISTAR STAFF DE LA CAFETERÍA
     */
    public function index()
    {
        $staff = User::where('role', 'personal')->get();
        return ApiResponse::success($staff, 'Lista del personal');
    }

    /**
     * CREAR NUEVO STAFF
     */
    public function store(Request $request)
    {
        $gerente = $request->user();

        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => [
                'required',
                Rule::unique('users', 'email')
            ],
            'password' => 'required|string|min:8'
        ]);

        // Obtener plan actual
        $plan = $gerente->cafeteria->plan_activo;

        if (!$plan) {
            return ApiResponse::error('La cafetería no tiene un plan activo.', 403);
        }

        // Contar staff activos de esta cafetería
        $staffActual = User::where('cafe_id', $gerente->cafe_id)
            ->where('role', 'personal')
            ->where('estado', true)
            ->count();

        // Validar límite de usuarios del plan
        if ($staffActual >= $plan->max_usuarios_admin) {

            return ApiResponse::error(
                'Tu plan permite máximo ' . $plan->max_usuarios_admin . ' usuarios.',
                403
            );
        }

        // Crear staff
        $staff = User::create([
            'name' => $data['name'],
            'email' => strtolower(trim($data['email'])),
            'password' => Hash::make($data['password']),
            'role' => 'personal',
            'cafe_id' => $gerente->cafe_id,
            'estado' => true
        ]);

        return ApiResponse::success($staff, 'Staff creado exitosamente');
    }


    /**
     * ACTUALIZAR STAFF
     */
    public function update(Request $request, $id)
    {
        $staff = User::where('role', 'personal')->find($id);

        if (!$staff) {
            return ApiResponse::error('Usuario no encontrado', 404);
        }

        $data = $request->validate([
            'name' => 'sometimes|string|max:100',
            'password' => 'sometimes|string|min:8|confirmed'
        ]);

        if (isset($data['name'])) {
            $staff->name = $data['name'];
        }

        if (isset($data['password'])) {
            $staff->password = Hash::make($data['password']);

            // cerrar sesiones activas
            $staff->tokens()->delete();
        }

        $staff->save();

        return ApiResponse::success(
            $staff,
            'Usuario actualizado correctamente'
        );
    }

    /**
     * DESACTIVAR STAFF
     */
    public function destroy(Request $request, User $staff)
    {
        if (!$staff) {
            return ApiResponse::error('Usuario no encontrado', 404);
        }

        $staff->update([
            'estado' => false
        ]);

        // cerrar sesión
        $staff->tokens()->delete();

        return ApiResponse::success(
            $staff,
            'Usuario desactivado correctamente'
        );
    }

    /**
     * REACTIVAR STAFF
     */
    public function activar(Request $request, $id)
    {
        $staff = User::where('role', 'personal')->find($id);

        if (!$staff) {
            return ApiResponse::error('Usuario no encontrado', 404);
        }

        // Obtener plan actual y verificar límite de usuarios
        $gerente = $request->user();
        $plan = $gerente->cafeteria->plan_activo;

        if ($plan) {
            $staffActual = User::where('cafe_id', $gerente->cafe_id)
                ->where('role', 'personal')
                ->where('estado', true)
                ->count();

            if ($staffActual >= $plan->max_usuarios_admin) {
                return ApiResponse::error(
                    'Tu plan permite máximo ' . $plan->max_usuarios_admin . ' usuarios.',
                    403
                );
            }
        }

        $staff->update([
            'estado' => true
        ]);

        return ApiResponse::success(
            $staff,
            'Usuario reactivado correctamente'
        );
    }
}
