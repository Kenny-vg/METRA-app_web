<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    /** Crea un usuario con los parámetros dados */
    private function crearUsuario(string $role, string $email, bool $estado = true): User
    {
        return User::create([
            'name'     => ucfirst($role) . ' Test',
            'email'    => $email,
            'password' => Hash::make('123456'),
            'role'     => $role,
            'estado'   => $estado,
            'cafe_id'  => null,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | TESTS: LOGIN EXITOSO (los 4 tipos de usuario)
    |--------------------------------------------------------------------------
    */

    #[Test]
    public function login_superadmin_exitoso()
    {
        $this->crearUsuario('superadmin', 'superadmin@metra.com');

        $response = $this->postJson('/api/login', [
            'email'    => 'superadmin@metra.com',
            'password' => '123456',
        ]);

        $response->assertStatus(200)
                 ->assertJsonPath('data.usuario.role', 'superadmin')
                 ->assertJsonStructure(['data' => ['token', 'usuario']]);
    }

    #[Test]
    public function login_gerente_exitoso()
    {
        $this->crearUsuario('gerente', 'gerente@metra.com');

        $response = $this->postJson('/api/login', [
            'email'    => 'gerente@metra.com',
            'password' => '123456',
        ]);

        $response->assertStatus(200)
                 ->assertJsonPath('data.usuario.role', 'gerente')
                 ->assertJsonStructure(['data' => ['token', 'usuario']]);
    }

    #[Test]
    public function login_personal_exitoso()
    {
        $this->crearUsuario('personal', 'staff@metra.com');

        $response = $this->postJson('/api/login', [
            'email'    => 'staff@metra.com',
            'password' => '123456',
        ]);

        $response->assertStatus(200)
                 ->assertJsonPath('data.usuario.role', 'personal')
                 ->assertJsonStructure(['data' => ['token', 'usuario']]);
    }

    #[Test]
    public function login_cliente_exitoso()
    {
        $this->crearUsuario('cliente', 'cliente@metra.com');

        $response = $this->postJson('/api/login', [
            'email'    => 'cliente@metra.com',
            'password' => '123456',
        ]);

        $response->assertStatus(200)
                 ->assertJsonPath('data.usuario.role', 'cliente')
                 ->assertJsonStructure(['data' => ['token', 'usuario']]);
    }

    /*
    |--------------------------------------------------------------------------
    | TESTS: CASOS DE ERROR (compartidos para todos los roles)
    |--------------------------------------------------------------------------
    */

    #[Test]
    public function login_falla_con_password_incorrecta()
    {
        $this->crearUsuario('superadmin', 'superadmin@metra.com');

        $response = $this->postJson('/api/login', [
            'email'    => 'superadmin@metra.com',
            'password' => 'wrongpass',
        ]);

        $response->assertStatus(401);
    }

    #[Test]
    public function login_falla_con_email_inexistente()
    {
        $response = $this->postJson('/api/login', [
            'email'    => 'noexiste@metra.com',
            'password' => '123456',
        ]);

        $response->assertStatus(401);
    }

    #[Test]
    public function login_falla_si_usuario_esta_inactivo()
    {
        $this->crearUsuario('gerente', 'gerente@metra.com', estado: false);

        $response = $this->postJson('/api/login', [
            'email'    => 'gerente@metra.com',
            'password' => '123456',
        ]);

        $response->assertStatus(403);
    }

    #[Test]
    public function login_falla_sin_campos_requeridos()
    {
        $response = $this->postJson('/api/login', []);

        $response->assertStatus(422); // Validation error
    }
}
