<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;


class CategoryCreatet extends Component
{



    use WithPagination;
    public $name;
    public $categories;
    public $newCategoryName;

    public $parentCategories;
    public $maxDepth;

    public $selectedCategory;

    public $lastSelectedParentCategory;
    public $selectedParentCategory1; // Agrega esta propiedad
    public $breadcrumbs;
    public $shortdescription, $longdescription, $image, $identificador, $order;

    protected $listeners = ['categorySelected', 'updateSelectedParentCategory'];

    public function mount()
    {
        // Obtener las categorías raíz
        $this->categories = Category::whereNull('parent_id')->get()->map(function ($category) {
            $category->depth = $this->calculateDepth($category);
            return $category;
        });

        $this->lastSelectedParentCategory = null;
        //$this->lastSelectedParentCategory = null;
        $this->selectedParentCategory1 = null;

        $this->identificador = rand();
    }

    public function updatedSelectedParentCategory1($value)
    {
        $this->lastSelectedParentCategory = $value;
    }

    public function categorySelected($value)
    {
        $this->lastSelectedParentCategory = $value;
    }

    public function updateSelectedParentCategory($value)
    {
        // Actualizar la variable lastSelectedParentCategory cuando se seleccione un nuevo radio button
        $this->selectedParentCategory1 = $value;
        //$this->lastSelectedParentCategory = $value;

    }

    protected function calculateDepth($category, $depth = 0)
    {
        if (!$category->parent) {
            return $depth;
        } else {
            return $this->calculateDepth($category->parent, $depth + 1);
        }
    }

    public function save()
    {
        // Validación del nombre de la categoría
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        if ($this->lastSelectedParentCategory) {
            $categoryreference = Category::find($this->lastSelectedParentCategory);
            $depth = $categoryreference->depth + 1;
            $path = $categoryreference->path . "/" . $this->name;
        } else {
            $depth = 0;
            $path = $this->name;
        }
        // Crear la nueva categoría
        Category::create([
            'name' => $this->name,
            'parent_id' => $this->lastSelectedParentCategory ?? null, // Asignar la categoría padre si se seleccionó
            'shortdescription' =>  $this->shortdescription,
            'longdescription' =>  $this->longdescription,
            'order' =>  $this->order,
            'depth' => $depth,
            'path' => $path,
            'company_id' => auth()->user()->employee->company->id,
        ]);
        // Limpiar los campos después de la creación
        //$this->name = '';
        //$this->selectedCategory = null;
        $this->emit('alert', 'La Categoria se creo correctamente');
        //$this->render();
        //return view('livewire.admin.category-listd');
        return redirect()->route('category.listd');

        // Actualizar la lista de categorías
        /*  $this->categories = Category::whereNull('parent_id')->get()->map(function ($category) {
            $category->depth = $this->calculateDepth($category);
            return $category;
        }); */
    }


    public function render()
    {
        if ($this->lastSelectedParentCategory) {
            $categoryreference = Category::find($this->lastSelectedParentCategory);
            $this->breadcrumbs = $categoryreference->path;
        } else {
            $this->breadcrumbs = '/';
        }

        //dd($categoryreference);


        return view('livewire.admin.category-createt');
    }
}
