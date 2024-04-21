<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;

class CategoryListd extends Component
{
    use WithPagination;

    public $categories;

    public function mount()
    {
        // Obtener las categorías raíz y calcular su profundidad
        $this->categories = Category::whereNull('parent_id')->get();
        /* $this->categories = Category::whereNull('parent_id')->get()->map(function ($category) {
            $category->depth = $this->calculateDepth($category);
            return $category;
        }); */
        // dd($this->categories );
    }

    /*   protected function calculateDepth($category, $depth = 0)
    {

        if (!$category->parent) {
            return $depth;
        } else {
            return $this->calculateDepth($category->parent, $depth + 1);
        }
    } */

    public function render()
    {

            /*  $categoriesPaginated = $this->categories->paginate(5);

        return view('livewire.admin.category-listd', ['categories' => $categoriesPaginated]) */;
        // Obtener las categorías raíz y paginar los resultados
        //$categories = Category::whereNull('parent_id')->paginate(5);

        return view('livewire.admin.category-listd');
    }
}
