<?php

namespace App\Http\Livewire\Admin;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;



class CategoryList extends Component
{

    use WithPagination;
    public $search, $categoriess, $state;
    public $sort='id';
    public $direction='desc';
    public $cant='10';

    public function updatingSearch(){
        $this->resetPage();
    }


    public function render()
    {

        $categories = Category::where('name', 'like', '%' . $this->search . '%')->paginate(10);
        return view('livewire.admin.category-list', compact('categories'));
    }

    public function activar(Category $category){
        $this->categoriess = $category;

        $this->categoriess->update([
            'state' => 1
        ]);
    }

    public function desactivar(Category $category){
        $this->categoriess = $category;

        $this->categoriess->update([
            'state' => 0
        ]);
    }



}
