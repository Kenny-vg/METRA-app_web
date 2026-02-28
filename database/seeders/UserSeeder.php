<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       /*
        |--------------------------------------------------------------------------
        | SUPERADMIN
        |--------------------------------------------------------------------------
        | No pertenece a ninguna cafetería
        */
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@metra.com',
            'password' => Hash::make('12345678'),
            'role' => 'superadmin',
            'estado' => true,
            'cafe_id' => null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | GERENTE DE PRUEBA
        |--------------------------------------------------------------------------
        | Pertenece a cafetería 1
        */
        User::create([
            'name' => 'Gerente Test',
            'email' => 'gerente@metra.com',
            'password' => Hash::make('12345678'),
            'role' => 'gerente',
            'estado' => true,
            'cafe_id' => 1,
        ]);

        /*
        |--------------------------------------------------------------------------
        | PERSONAL DE PRUEBA
        |--------------------------------------------------------------------------
        */
        User::create([
            'name' => 'Staff Test',
            'email' => 'staff@metra.com',
            'password' => Hash::make('12345678'),
            'role' => 'personal',
            'estado' => true,
            'cafe_id' => 1,
        ]);


        User::create([
        'name' => 'Cliente Test',
        'email' => 'cliente@metra.com',
        'password' => Hash::make('12345678'),
        'role' => 'cliente',
        'estado' => true,
        'cafe_id' => null
        ]);
    }

    
}
