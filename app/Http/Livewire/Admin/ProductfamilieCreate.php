<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Modelo;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Builder;

class ProductfamilieCreate extends Component
{
    public $open = false;

    public $categories, $subcategories = [], $brands = [];
    public $category_id = "", $subcategory_id = "", $brand_id = "", $modelo_id = "", $partnumber, $send;
    public $name, $slug, $description, $price, $quantity;



    /* propiedad computada */
    public function getSubcategoryProperty(){
        return Subcategory::find($this->subcategory_id);
    }

    public function mount(){

        $this->categories = Category::all();
        $this->brands = Brand::all();
       // $this->subcategories = [];

    }




    public function nuevo(){
       // $this->identificador=rand();
        $this->open = true;
       // $this->reset(['image']);

    }

    
     public function updatedCategoryId($value){
        $this->subcategories = Subcategory::where('category_id', $value)->get();

/*          $this->brands = Brand::whereHas('categories', function(Builder $query) use ($value){
            $query->where('category_id', $value);
        })->get(); 

        $this->reset(['subcategory_id']); */
    } 



    public function render()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $modelos = Modelo::all();
        return view('livewire.admin.productfamilie-create', compact('categories', 'brands', 'modelos'));
    }

    public function save(){
        // $this->identificador=rand();
        // $this->open = true;
        // $this->reset(['image']);
       // $this->open = false;
       // return view('livewire.admin.productcompuesto-create');
       return redirect()->route('productcompuesto.create');
        

     }


}
