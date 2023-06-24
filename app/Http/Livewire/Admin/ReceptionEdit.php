<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Shipment;
use App\Models\Localproductatribute;
use App\Models\Local_productatribute_shipment;
use Carbon\Carbon;

class ReceptionEdit extends Component
{

    public $reception;
    public $local_productatribute_shipments;
    public $statereception;
    public $mensaje;
    public $total;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = '10';
    public $search;



    protected $listeners = ['confirmar'];

    protected $queryString = [
        'cant' => ['except' => '10'],
        'sort' => ['except' => 'id'],
        'direction' => ['except' => 'desc'],
        'search' => ['except' => ''],
    ];




    public function mount(Shipment $reception)
    {
        $this->reception = $reception;
        //$local = Local::find($this->shipment->id);
        //$this->local_recibe = $local->name;
        //$this->address_local_recibe = $local->address;
        $this->local_productatribute_shipments = Local_productatribute_shipment::where('shipment_id', $this->reception->id)->get();//tiene los productos para aceptar

        $this->total = Local_productatribute_shipment::where('shipment_id', $this->reception->id)->sum('quantity');

        $this->statereception = $this->reception->state;
        if ($this->statereception == 2) {
            $this->mensaje = "Pendiente";
        } elseif ($this->statereception == 3) {
            $this->mensaje = "Finalizado ...";
        }
    }

    public function render()
    {

        $this->local_productatribute_shipments = Local_productatribute_shipment::where('shipment_id', $this->reception->id)->get(); //selecciona todo los productos del envio actuatual
        //$this->total = Local_productatribute_shipment::where('shipment_id', $this->reception->id)->sum('quantity');

        $this->statereception = $this->reception->state;
        if ($this->statereception == 2) {
            $this->mensaje = "Pendiente";
        } elseif ($this->statereception == 3) {
            $this->mensaje = "Finalizado ...";
        }

        return view('livewire.admin.reception-edit');
    }



    public function confirmar()
    {

        // $this->local_productatribute_shipments = Local_productatribute_shipment::where('shipment_id', $this->shipment->id)->get();
        foreach ($this->local_productatribute_shipments as $lpas) {
            //buscamos en local_productatribute
            /* $lpa = Localproductatribute::where('local_id', Auth()->user()->local->id)
                                        ->where('id', $lpas->local_productatribute_id)->first(); */
            //$local = Localproductatribute::where('local_id', Auth()->user()->local->id)->first();
            //dd(Auth()->user()->local->id);
            //$prod = Localproductatribute::where('id', $lpas->local_productatribute_id)->first();
            //dd($lpas->local_productatribute_id);

            //dd($lpas->localproductatribute->productatribute_id);//tiene el codigo de productatribute_id
            //buscamos por local y por producto
            $lpa = Localproductatribute::where('local_id', Auth()->user()->local->id)
                                ->where('productatribute_id', $lpas->localproductatribute->productatribute_id)->first();

           /*  if ($lpa) { */
                $lpa->stock = $lpa->stock + $lpas->quantity;
                $lpa->save();
           /*  } */

        }
        //actualizamos el shipment
        $this->reception->state = 3;
        $this->reception->fechaaceptacion = Carbon::now();
        $this->reception->save();






    }
}
