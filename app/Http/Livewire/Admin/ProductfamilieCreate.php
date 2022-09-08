<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Modelo;

class ProductfamilieCreate extends Component
{
    public $open = false;

    public function nuevo(){
       // $this->identificador=rand();
        $this->open = true;
       // $this->reset(['image']);

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
