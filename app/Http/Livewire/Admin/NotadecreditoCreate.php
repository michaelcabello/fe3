<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Comprobante;
use App\Models\Comprobante_Product;

class NotadecreditoCreate extends Component
{

    public $comprobante;

    public function mount(Comprobante $id)
    {
        $this->comprobante = $id;
    }






    public function render()
    {
        $detalle = Comprobante_Product::where('comprobante_id', $this->comprobante->id)->get();
        return view('livewire.admin.notadecredito-create', Compact('detalle'));
    }
}
