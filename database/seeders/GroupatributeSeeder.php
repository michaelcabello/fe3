<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Groupatribute;

class GroupatributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Groupatribute::create([
            'name' => 'Tallas',
            'state'=>1,
            'order'=>1,
        ]);

        Groupatribute::create([
            'name' => 'Colores',
            'state'=>1,
            'order'=>2,
        ]);

    }
}
