<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Category::create([
            'name' => 'General',
            'slug' => Str::slug('General'),
            'state'=>1,
        ]);

        $category1 = Category::create([
            'name' => 'Ropas para Damas',
            'slug' => Str::slug('Ropas para Damas'),
            'state'=>1,
        ]);



        Category::create([
            'name' => 'Ropas para Varones',
            'slug' => Str::slug('Ropas para Varones'),
            'state'=>1,
        ]);

        Category::create([
            'name' => 'artefactos electricos',
            'slug' => Str::slug('artefactos electricos'),
            'state'=>1,
        ]);

        Category::create([
            'name' => 'Computo',
            'slug' => Str::slug('computo'),
            'state'=>1,
        ]);

        Category::create([
            'name' => 'Cereales',
            'slug' => Str::slug('Cereales'),
            'state'=>1,
        ]);

        Category::create([
            'name' => 'Lacteos',
            'slug' => Str::slug('Lacteos'),
            'state'=>1,
        ]);

        Category::create([
            'name' => 'Refrescos',
            'slug' => Str::slug('Refrescos'),
            'state'=>1,
        ]);

        Category::create([
            'name' => 'Licores',
            'slug' => Str::slug('Licores'),
            'state'=>1,
        ]);

        Category::create([
            'name' => 'Muebles',
            'slug' => Str::slug('muebles'),
            'state'=>1,
        ]);


        Category::create([
            'name' => 'sacos de polipropileno',
            'slug' => Str::slug('sacos de polipropileno'),
            'state'=>1,
        ]);





    }
}
