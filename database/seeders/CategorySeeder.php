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
            'name' => 'Hosting',    
            'url' => Str::slug("Hosting"),
            'image' => 'public/category/category1.jpg', 
            'description' => 'hosting de paginas web', 
            'state' => 1,          
           
        ]);

        Category::create([
            'name' => 'Ropas',    
            'url' => Str::slug("ropas"),
            'image' => 'public/category/category2.jpg', 
            'description' => 'hosting de paginas web', 
            'state' => 1,          
           
        ]);
    }
}
