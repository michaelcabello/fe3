<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;

class CategoryCreated extends Component
{

    public $selectedCategory;
    public $name;


    public function mount()
    {

        //$this->selectedCategory = 2;
    }

    public function render()
    {
        // Obtener las categorías raíz para el primer select

        return view('livewire.admin.category-created');
    }

    public function save(){
        Category::create([
            'name'=> $this->name,
            'parent_id' => 2

        ]);



    }
}

