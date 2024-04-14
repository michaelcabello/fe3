<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;

class CategoryEditd extends Component
{

    public $categoryId;

    public function mount($categoryId)
    {
        $this->categoryId = $categoryId;
    }

    public function render()
    {
        // Obtener la categoría para editar
        $category = Category::findOrFail($this->categoryId);
        return view('livewire.admin.category-editd', compact('category'));
        //return view('livewire.admin.category-editd');
    }
}
