<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {


    

     $categories = Category::whereNull('category_id')
        ->with('childrenCategories')
        ->paginate(5);
        //->get();
    //return view('categorias', compact('categories'));

    return view('livewire.admin.category-listd', compact('categories'));
    }
}
