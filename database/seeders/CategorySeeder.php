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
            'name' => 'Celulares y tablets',
            'slug' => Str::slug('Celulares y tablets'),
            'state'=>1,
        ]);

        Category::create([
            'name' => 'Ropas para Damas',
            'slug' => Str::slug('Ropas para Damas'),
            'state'=>1,
        ]);

        Category::create([
            'name' => 'Ropas para Varones',
            'slug' => Str::slug('Ropas para Damas'),
            'state'=>1,
        ]);

        Category::create([
            'name' => 'artefactos electricos',
            'slug' => Str::slug('artefactos electricos'),
            'state'=>1,
        ]);

        Category::create([
            'name' => 'monitores y placas',
            'slug' => Str::slug('monitores y placas'),
            'state'=>1,
        ]);

        Category::create([
            'name' => 'colegios',
            'slug' => Str::slug('Colegios'),
            'state'=>1,
        ]);

        Category::create([
            'name' => 'laptops y notebooks',
            'slug' => Str::slug('laptops y notebooks'),
            'state'=>1,
        ]);

        Category::create([
            'name' => 'muebles en melamine',
            'slug' => Str::slug('muebles en melamine'),
            'state'=>1,
        ]);



        Category::create([
            'name' => 'Chompas',
            'slug' => Str::slug('Chompas'),
            'state'=>1,
        ]);

        Category::create([
            'name' => 'mouses ina',
            'slug' => Str::slug('mouses ina'),
            'state'=>1,
        ]);

        Category::create([
            'name' => 'zapatos vid',
            'slug' => Str::slug('zapatos vid'),
            'state'=>1,
        ]);

       


        Category::create([
            'name' => 'mesas billar',
            'slug' => Str::slug('mesas billar'),
            'state'=>1,
        ]);

        Category::create([
            'name' => 'cremas manos',
            'slug' => Str::slug('cremas manos'),
            'state'=>1,
        ]);

        Category::create([
            'name' => 'ternos matri',
            'slug' => Str::slug('ternos matri'),
            'state'=>1,
        ]);

        Category::create([
            'name' => 'buzos mar',
            'slug' => Str::slug('buzos mar'),
            'state'=>1,
        ]);

        Category::create([
            'name' => 'sacos poli',
            'slug' => Str::slug('sacos poli'),
            'state'=>1,
        ]);

        Category::create([
            'name' => 'vidrios templados',
            'slug' => Str::slug('vidrios templados'),
            'state'=>1,
        ]);



    }
}
