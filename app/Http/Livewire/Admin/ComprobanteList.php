<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Comprobante;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class ComprobanteList extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    //public $shopping;
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

    public function loadComprobantes()
    {
        $this->readyToLoad = true;
    }


    /* public function render()
    {
        if ($this->readyToLoad) {
            $comprobantes = Comprobante::with('customer', 'local')->addSelect([
                'nomrazonsocial' => Customer::select('nomrazonsocial')
                    ->whereColumn('id', 'comprobantes.customer_id')
            ])->where('serie', 'like', '%' . $this->search . '%')->orWhereHas('customer', function (Builder $query) {
                $query->where('nomrazonsocial', 'like', '%' . $this->search . '%');
            })->orderBy($this->sort, $this->direction)->paginate($this->cant);
        } else {
            $comprobantes = [];
        }

        return view('livewire.admin.comprobante-list', compact('comprobantes'));
    } */


    public function render()
    {
        if ($this->readyToLoad) {



            $company_id = auth()->user()->employee->company->id;
            $local_id = auth()->user()->employee->local->id;

            /* $comprobantes = Comprobante::with('customer', 'local')->addSelect([
                'nomrazonsocial' => Customer::select('nomrazonsocial')->whereColumn('id', 'comprobantes.customer_id')
            ])->select('serienumero', 'valorventa','totalimpuestos','mtoimpventa', 'currency_id')
            ->where('company_id', $company_id)
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant); */

            $comprobantes = Comprobante::select('serienumero', 'valorventa','totalimpuestos','mtoimpventa', 'currency_id', 'customer_id')
            ->where('company_id', $company_id)
            ->where('local_id', $local_id)
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);



        } else {
            $comprobantes = [];
        }


        /* return view('livewire.admin.comprobante-list', [
            'comprobantes' => $comprobantes->map(function ($comprobante) {
                $comprobante->formattedFechaEmision = Carbon::parse($comprobante->fechaemision)->format('d/m/Y');
                return $comprobante;
            }),
        ]); */

        return view('livewire.admin.comprobante-list', compact('comprobantes'));
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
