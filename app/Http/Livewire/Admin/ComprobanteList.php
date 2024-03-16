<?php

namespace App\Http\Livewire\Admin;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Customer;
use App\Models\Impuesto;
use App\Models\Temporal;
use App\Models\Temporalnc;
use App\Models\Comprobante;
use Livewire\WithPagination;
use App\Services\SunatService;
use App\Models\Comprobante_Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

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
    public $company;
    public $igv, $factoricbper;

    protected $queryString = [
        'cant' => ['except' => '10'],
        'sort' => ['except' => 'id'],
        'direction' => ['except' => 'desc'],
        'search' => ['except' => ''],
    ];

    public $temporal = [
        'company_id' => [],
        'product_id' => [],
        'codigobarras' => [],
        'employee_id' => [],
        'image' => [],
        'name' => [],
        'um' => [],
        'tipafeigv' => [],
        'saleprice' => [],
        'mtovalorunitario' => [],
        'porcentajeigv' => [],
        'factoricbper' => [],
        'discount' => [],
        'salepricef' => [],
        'quantity' => [],
        'subtotal' => [],
        'igv' => [],
        'totalimpuestos' => [],
        'icbper' => [],
        'mtovalorventa' => [],
        'mtobaseigv' => [],
        'esbolsa' => [],
    ];


    public function mount()
    {

        $this->company = auth()->user()->employee->company;
        $this->igv = Impuesto::where('siglas', 'IGV')->value('valor'); //es el 18%
        $this->factoricbper = Impuesto::where('siglas', 'ICBPER')->value('valor'); //es 0.2
    }



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

            $comprobantes = Comprobante::select('id', 'serienumero', 'valorventa', 'totalimpuestos', 'mtoimpventa', 'currency_id', 'customer_id', 'tipocomprobante_id')
                ->where('serienumero', 'like', '%' . $this->search . '%')
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

    public function llenartemporal($detalle)
    {
        foreach ($detalle as $item) {

            $mtovalorunitario = $item->price / (1 + ($this->igv * 0.01)); //actualizamos//precio de producto sin inc igv ejemplo 100

            Temporalnc::create([
                //'serienumero' => $item->comprobante->serienumero,
                'quantity' => $item->cant,
                'saleprice' => $item->price,
                'subtotal' => $item->subtotal,
                'product_id' => $item->product_id,
                'comprobante_id' => $item->comprobante_id,
                'company_id' => $item->company_id,
                'employee_id' => auth()->user()->employee->id,
                'codigobarras' => $item->codigobarras, //codigo del producto que necesita la facturacion electronica
                'igv' => $item->igv,
                'icbper' => $item->icbper,
                'totalimpuestos' => $item->totalimpuestos,
                'mtovalorunitario' => floatval($mtovalorunitario),
                'mtovalorventa' => floatval($item->mtovalorventa),
                'mtobaseigv' => floatval($item->mtobaseigv),
                'name' => $item->product->name,
                'um' => $item->product->um->abbreviation,
                'tipafeigv' => $item->product->tipoafectacion->codigo,
                'porcentajeigv' => $this->igv,  //igv lo tenemos en el mount es 18%
                'factoricbper' => $this->factoricbper,  //factoricbper lo tenemos en el mount es 0.2


            ]);
        }
    }
    public function generateXml(Comprobante $comprobante)
    {
        //dd($comprobante);
        //$temporals = Comprobante_Product::where('comprobante_id', $comprobante->id)->get();
        //obtenemos temporals para factura y boleta
        if ($comprobante->tipocomprobante_id == 1 or $comprobante->tipocomprobante_id == 2) {
            $temporals = Temporal::where('company_id', auth()->user()->employee->company->id)
                ->where('employee_id', auth()->user()->employee->id)
                ->where('state', 1) //el state 1 indica que el comprobante esta en el temporal, para indicar que se guardo pero no se termino de enviar a sunat
                ->where('comprobante_id', $comprobante->id)->get(); //state 0 tiene los temporales actuales, 1 ya esta grabado pero no enviado a sunat
        } elseif ($comprobante->tipocomprobante_id == 3 or $comprobante->tipocomprobante_id == 5) {
            $detalle = Comprobante_Product::where('comprobante_id', $comprobante->id)
                ->where('company_id', auth()->user()->employee->company->id)->get(); //falta restringir para que solo ,uestre lo que le corresponde osea no de otro local ni de otra empresa
            $this->llenartemporal($detalle);
            $temporals = Temporalnc::where('company_id', auth()->user()->employee->company->id)
                ->where('employee_id', auth()->user()->employee->id)->get();
        }


        if ($comprobante->tipocomprobante_id == 1) {
            $sunat = new SunatService($comprobante, $this->company, $temporals, $comprobante->factura);
        } elseif ($comprobante->tipocomprobante_id == 2) {
            $sunat = new SunatService($comprobante, $this->company, $temporals, $comprobante->boleta);
        } elseif ($comprobante->tipocomprobante_id == 3) {
            $sunat = new SunatService($comprobante, $this->company, $temporals, $comprobante->ncfactura);
        } elseif ($comprobante->tipocomprobante_id == 5) {
            $sunat = new SunatService($comprobante, $this->company, $temporals, $comprobante->ncboleta);
        }

        //dd($sunat);
        $sunat->getSee();

        if ($comprobante->tipocomprobante_id == 1 or $comprobante->tipocomprobante_id == 2) {
            $sunat->setInvoice();
            $sunat->generateXml(); ////send es el metodo de greenter
        }
        if ($comprobante->tipocomprobante_id == 3 or $comprobante->tipocomprobante_id == 5) {
            $sunat->setNota();
            $sunat->generateXml(); ////send es el metodo de greenter
            $temporals->each->delete();
        }

        //$sunat->setInvoice();

        $this->emit('alert', 'El comprobante se creo y firmo correctamente, pero no se envio a SUNAT');
    }


    public function sendSunat(Comprobante $comprobante)
    {
        //si es factura o boleta genera temporal para ejecutar con setInvoice
        if ($comprobante->tipocomprobante_id == 1 or $comprobante->tipocomprobante_id == 2) {
            $temporals = Temporal::where('company_id', auth()->user()->employee->company->id)
                ->where('employee_id', auth()->user()->employee->id)
                ->where('state', 1)
                ->where('comprobante_id', $comprobante->id)->get(); //state 0 tiene los temporales actuales, 1 ya esta grabado pero no enviado a sunat
        } elseif ($comprobante->tipocomprobante_id == 3 or $comprobante->tipocomprobante_id == 5) {
            //si es ncfactura o ncboleta genera temporal para ejecutar con setNota
            $detalle = Comprobante_Product::where('comprobante_id', $comprobante->id)
                ->where('company_id', auth()->user()->employee->company->id)->get(); //falta restringir para que solo ,uestre lo que le corresponde osea no de otro local ni de otra empresa

            $this->llenartemporal($detalle);

            $temporals = Temporalnc::where('company_id', auth()->user()->employee->company->id)
                ->where('employee_id', auth()->user()->employee->id)->get();
        }



        if ($comprobante->tipocomprobante_id == 1) {
            $sunat = new SunatService($comprobante, $this->company, $temporals, $comprobante->factura);
        } elseif ($comprobante->tipocomprobante_id == 2) {
            $sunat = new SunatService($comprobante, $this->company, $temporals, $comprobante->boleta);
        } elseif ($comprobante->tipocomprobante_id == 3) {
            $sunat = new SunatService($comprobante, $this->company, $temporals, $comprobante->ncfactura);
        } elseif ($comprobante->tipocomprobante_id == 5) {
            $sunat = new SunatService($comprobante, $this->company, $temporals, $comprobante->ncboleta);
        }

        $sunat->getSee();

        if ($comprobante->tipocomprobante_id == 1 or $comprobante->tipocomprobante_id == 2) {
            $sunat->setInvoice();
        }
        if ($comprobante->tipocomprobante_id == 3 or $comprobante->tipocomprobante_id == 5) {
            $sunat->setNota();
        }

        $sunat->send();

        $temporals->each->delete(); //eliminamos del temporal porque ya se envio a Sunat
        $this->emit('alert', 'El comprobante se envio a sunat');
    }
}
