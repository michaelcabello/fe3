<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subcategory;
use Illuminate\Support\Str;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subcategory::create([
            'name' => 'bluzas floriadas',
            'slug' => Str::slug('bluzas floriadas'),
            'state'=>1,
            'category_id'=>2
        ]);

        Subcategory::create([
            'name' => 'pantalon pitillo',
            'slug' => Str::slug('pantalon pitillo'),
            'state'=>1,
            'category_id'=>2
        ]);

        Subcategory::create([
            'name' => 'brazieres',
            'slug' => Str::slug('brazieres'),
            'state'=>1,
            'category_id'=>2
        ]);

        Subcategory::create([
            'name' => 'camisas',
            'slug' => Str::slug('camisas'),
            'state'=>1,
            'category_id'=>3
        ]);

        Subcategory::create([
            'name' => 'pantalones',
            'slug' => Str::slug('pantalones'),
            'state'=>1,
            'category_id'=>3
        ]);
    }
}
