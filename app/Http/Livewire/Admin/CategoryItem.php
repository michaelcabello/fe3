<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;

class CategoryItem extends Component
{

    public $category;
    public $isOpen = false;

    public function mount(Category $category, $isOpen = false)
    {
        $this->category = $category;
        $this->isOpen = $isOpen;
    }

    public function toggle()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function render()
    {
        //return view('livewire.admin.category-item');
        return view('livewire.admin.category-item', [
            'depth' => $this->calculateDepth($this->category),
        ]);
    }

    protected function calculateDepth($category, $depth = 0)
    {
        if (!$category->parent) {
            return $depth;
        } else {
            return $this->calculateDepth($category->parent, $depth + 1);
        }
    }


    public function hasChildren()
    {
        return $this->category->children->isNotEmpty();
    }

    public function editCategory($categoryId)
    {
        return view('livewire.admin.category-editd');
        // Emitir un evento para que el componente padre maneje la edición
        //$this->emit('editCategory', $categoryId);
        //dd($categoryId);
    }

    public function confirmDeleteCategory($categoryId)
    {
        // Emitir un evento para que el componente padre maneje la eliminación
        $this->emit('confirmDeleteCategory', $categoryId);
    }


}
