<?php

namespace App\Helpers;

use Illuminate\Validation\Rules\Password;

class PasswordHelper
{
    /**
     * Define la política de seguridad para contraseñas de METRA (Nivel Medio).
     * Mínimo 8 caracteres, debe contener letras y números.
     */
    public static function securePasswordPolicy()
    {
        return Password::min(8)
            ->letters()
            ->numbers();
    }

    /**
     * Mensajes de error personalizados para la política de seguridad.
     */
    public static function messages()
    {
        return [
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.letters' => 'La contraseña debe contener al menos una letra.',
            'password.numbers' => 'La contraseña debe contener al menos un número.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'gerente.password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'gerente.password.letters' => 'La contraseña debe contener al menos una letra.',
            'gerente.password.numbers' => 'La contraseña debe contener al menos un número.',
            'gerente.password.confirmed' => 'La confirmación de la contraseña no coincide.',
        ];
    }
}
