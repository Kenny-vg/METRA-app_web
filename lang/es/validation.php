<?php

return [
    'required' => 'El campo :attribute es obligatorio.',
    'unique' => 'El valor de :attribute ya ha sido registrado.',
    'email' => 'El campo :attribute debe ser un correo electrónico válido.',
    'min' => [
        'string' => 'El campo :attribute debe tener al menos :min caracteres.',
    ],
    'max' => [
        'string' => 'El campo :attribute no debe ser mayor a :max caracteres.',
    ],
    'confirmed' => 'La confirmación del campo :attribute no coincide.',

    'custom' => [
        'gerente.email' => [
            'unique' => 'El correo del gerente ya ha sido registrado.',
        ],
    ],

    'attributes' => [
        'gerente.name' => 'nombre del gerente',
        'gerente.email' => 'correo del gerente',
        'gerente.password' => 'contraseña',
        'nombre' => 'nombre del negocio',
        'calle' => 'calle',
        'num_exterior' => 'número exterior',
        'colonia' => 'colonia',
        'ciudad' => 'ciudad',
        'estado_republica' => 'estado',
        'cp' => 'código postal',
        'telefono' => 'teléfono',
    ],
];
