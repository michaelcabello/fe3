<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Groupatribute;

class ProductcompuestoCreate extends Component
{
    public function render()
    {
        //$categories = Category::all();
        $groupatributes = Groupatribute::all();
        //return view('miempresa.miscategoriass', compact('user', 'categories'));
        return view('livewire.admin.productcompuesto-create', compact('groupatributes'));
    }
}
