<?php

namespace App\Http\Livewire\Admin;

use App\Models\Comprobante;
use Livewire\Component;

class ComprobanteList extends Component
{

    public $name;

    public function render()
    {
        $comprobantes = Comprobante::all(); 

        return view('livewire.admin.comprobante-list', compact('comprobantes'));
    }
}
