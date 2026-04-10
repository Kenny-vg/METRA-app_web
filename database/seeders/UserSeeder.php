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
        */
        User::updateOrCreate([
            'email' => 'superadmin@metra.com',
        ], [
            'name' => 'Super Admin',
            'password' => Hash::make('12345678'),
            'role' => 'superadmin',
            'estado' => true,
            'cafe_id' => null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | GERENTES DE PRUEBA
        |--------------------------------------------------------------------------
        */
        User::updateOrCreate([
            'email' => 'gerente@metra.com',
        ], [
            'name' => 'Gerente Luxury',
            'password' => Hash::make('12345678'),
            'role' => 'gerente',
            'estado' => true,
            'cafe_id' => 1,
        ]);

        User::updateOrCreate([
            'email' => 'sabroso@metra.com',
        ], [
            'name' => 'Gerente Sabroso',
            'password' => Hash::make('12345678'),
            'role' => 'gerente',
            'estado' => true,
            'cafe_id' => 2,
        ]);

        /*
        |--------------------------------------------------------------------------
        | PERSONAL DE PRUEBA
        |--------------------------------------------------------------------------
        */
        User::updateOrCreate([
            'email' => 'staff@metra.com',
        ], [
            'name' => 'Staff Test',
            'password' => Hash::make('12345678'),
            'role' => 'personal',
            'estado' => true,
            'cafe_id' => 1,
        ]);

        User::updateOrCreate([
            'email' => 'staff_sabroso@metra.com',
        ], [
            'name' => 'Staff Sabroso',
            'password' => Hash::make('12345678'),
            'role' => 'personal',
            'estado' => true,
            'cafe_id' => 2,
        ]);

        User::updateOrCreate([
            'email' => 'cliente@metra.com',
        ], [
            'name' => 'Cliente Test',
            'password' => Hash::make('12345678'),
            'role' => 'cliente',
            'estado' => true,
            'cafe_id' => null
        ]);
    }

    
}
