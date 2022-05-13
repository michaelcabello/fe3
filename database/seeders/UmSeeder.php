<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Um;

class UmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Um::create([
            'name' => 'metros',    
            'abbreviation' => 'm', 
            'state' => 1,
        ]);


        Um::create([
            'name' => 'unidades',    
            'abbreviation' => 'u', 
            'state' => 1,
        ]);


        Um::create([
            'name' => 'docena',    
            'abbreviation' => 'doc', 
            'state' => 1,
        ]);

        Um::create([
            'name' => 'ciento',    
            'abbreviation' => 'cien', 
            'state' => 1,
        ]);
    }
}
