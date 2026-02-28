<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cafeteria;

class CafeteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Cafeteria::create([
            'id' => 1,
            'nombre' => 'Cafe Demo METRA',
            'estado' => true
        ]);
    }
}
