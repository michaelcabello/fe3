<?php

namespace App\Http\Livewire\Admin;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class CategoryList extends Component
{
    use AuthorizesRequests;
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
        $this->authorize('create', new Category);

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
