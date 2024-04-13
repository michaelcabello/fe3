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
        // Obtener las categorías raíz
        // Obtener las categorías raíz
        $this->categories = Category::whereNull('parent_id')->get()->map(function ($category) {
            $category->depth = $this->calculateDepth($category);
            return $category;
        });
        //$this->categories = Category::whereNull('parent_id')->get();
    }

    protected function calculateDepth($category, $depth = 0)
    {
        if (!$category->parent) {
            return $depth;
        } else {
            return $this->calculateDepth($category->parent, $depth + 1);
        }
    }

    public function render()
    {
        return view('livewire.admin.category-listd');
    }
}
