<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Modelo;

class ModeloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Modelo::create([
            'name' => 'Modelo Venecia',    
            'state' => 1,           
        ]);

        Modelo::create([
            'name' => 'Modelo Flor',    
            'state' => 1,           
        ]);

        Modelo::create([
            'name' => 'Modelo Laydy',    
            'state' => 1,           
        ]);

        Modelo::create([
            'name' => 'Modelo Estrella',    
            'state' => 1,           
        ]);

        Modelo::create([
            'name' => 'Modelo Django',    
            'state' => 1,           
        ]);

        Modelo::create([
            'name' => 'Modelo Polar',    
            'state' => 1,           
        ]);
    }
}
