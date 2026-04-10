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
            'email' => 'aimankendra22@gmail.com',
        ], [
            'name' => 'Super Admin',
            'password' => Hash::make('12345678'),
            'role' => 'superadmin',
            'estado' => true,
            'cafe_id' => null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | GERENTE DE PRUEBA (LUXURY)
        |--------------------------------------------------------------------------
        */
        User::updateOrCreate([
            'email' => 'gerente@metra.com',
        ], [
            'name' => 'Gerente Luxury',
            'password' => Hash::make('12345678'),
            'role' => 'gerente',
            'estado' => true,
            'cafe_id' => null, // Se asigna en CafeteriaSeeder si es necesario, o lo dejamos así
        ]);

        /*
        |--------------------------------------------------------------------------
        | PERSONAL DE PRUEBA (LUXURY)
        |--------------------------------------------------------------------------
        */
        User::updateOrCreate([
            'email' => 'staff@metra.com',
        ], [
            'name' => 'Staff Luxury',
            'password' => Hash::make('12345678'),
            'role' => 'personal',
            'estado' => true,
            'cafe_id' => null,
        ]);
    }


}
