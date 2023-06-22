<?php

namespace App\Http\Livewire\Admin;

use App\Models\Local;
use Livewire\Component;
use App\Models\Shipment;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class ShipmentList extends Component
{

    use AuthorizesRequests;
    use WithPagination;
    public $shopping;
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $cant = '10';
    public $readyToLoad = false; //para controlar el preloader inicia en false

    protected $queryString = [
        'cant' => ['except' => '10'],
        'sort' => ['except' => 'id'],
        'direction' => ['except' => 'desc'],
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
        //RESETEA la paginación, updating() cuando se cambia una de las propiedades  updatingSearch() cuando se cambia la propiedad search
    }

    public function loadShipments()
    {
        $this->readyToLoad = true;
    }


    public function render()
    {

        if ($this->readyToLoad) {

            $shipments = Shipment::with('localRecibe')->addSelect([
                'name' => Local::select('name')
                    ->whereColumn('id', 'shipments.local_recibe_id')
            ])->where('id', 'like', '%' . $this->search . '%')->orWhereHas('localRecibe', function (Builder $query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })->orderBy($this->sort, $this->direction)->paginate($this->cant);
        } else {
            $shipments = [];
        }


        return view('livewire.admin.shipment-list', compact('shipments'));
    }

    public function order($sort)
    {
        if ($this->sort == $sort) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
    }
}
