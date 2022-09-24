<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Productatribute;
use App\Models\Productfamilie;

class ProductcompuestoList extends Component
{

    public $product;

    public function mount(Productfamilie $product){
        $this->product = $product;//recibimos producto
    }

    public function render()
    {
        return view('livewire.admin.productcompuesto-list');
    }
}
