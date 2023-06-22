<?php

namespace App\Http\Livewire\Admin;

use Carbon\Carbon;
use App\Models\Local;
use Livewire\Component;
use App\Models\Shipment;

use Illuminate\Support\Facades\Auth;


class ShipmentCreate extends Component
{
    public $open = false;
    public $name, $local_recibe_id="";
    public $locales;


    protected $rules = [
        'local_recibe_id' => 'required',
        'name' => 'required',

    ];

    public function mount()
    {
        $this->locales = Local::where('id', '!=', Auth::user()->local->id)->get();
    }





    public function render()
    {
        //$currentUser = Auth::user()->local;
       // $locales = Local::where('id', '!=', $currentUser->id)->get();

        //$cart = Cartenvio::getContent()->sortBy('name');

        return view('livewire.admin.shipment-create');
    }


    public function updatingOpen()
    {
        if ($this->open == false) {
            $this->reset('name', 'local_recibe_id');
        }
    }

    public function saveok()
    {
        $this->validate();
        //ahora hay que restringir y hacer que grabe todo o nada  cabecera y detalle

        //guardamos el nuevo inventario cabecera
        $shipment = Shipment::create([
            'name' => $this->name,
            'local_envia_id' => Auth::user()->local->id,
            'local_recibe_id' => $this->local_recibe_id,
            'fechaenvio' => Carbon::now(),
            'state' => 1,
            'total' => 0,
            'nota' => "",
        ]);


        //redireccionar al envio creado
        return redirect()->route('shipment.edit', $shipment);
    }
}
