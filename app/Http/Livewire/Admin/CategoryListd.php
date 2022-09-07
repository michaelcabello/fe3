<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;

class CategoryListd extends Component
{
    
    use WithPagination;

    public function render()
    {
        $categories = Category::whereNull('category_id')
        ->with('childrenCategories')
        ->paginate(5);
        //->get();
        //  return view('categorias', compact('categories'));

       // dd($categories);

        return view('livewire.admin.category-listd', compact('categories'));
    }
}
