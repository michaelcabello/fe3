<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
class CategoryList extends Component
{
    public function render()
    {


        $categories = Category::all(); 

        return view('livewire.admin.category-list', compact('categories'));
    }
}
