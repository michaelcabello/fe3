<?php

namespace App\Http\Livewire\Admin;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Customer;
use App\Models\Temporal;
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


    public function generateXml(Comprobante $comprobante)
    {
        //dd($comprobante);
        //$temporals = Comprobante_Product::where('comprobante_id', $comprobante->id)->get();
        $temporals = Temporal::where('company_id', auth()->user()->employee->company->id)
        ->where('employee_id', auth()->user()->employee->id)
        ->where('state',1)
        ->where('comprobante_id', $comprobante->id)->get();//state 0 tiene los temporales actuales, 1 ya esta grabado pero no enviado a sunat

        //dd($temporals);

        $sunat = new SunatService($comprobante, $this->company, $temporals, $comprobante->factura);
       //dd($sunat);
        $sunat->getSee();
        $sunat->setInvoice();
        $sunat->generateXml(); ////send es el meto de greenter
        $this->emit('alert', 'El comprobante se creo y firmo correctamente, pero no se envio a SUNAT');
    }


    public function sendSunat(Comprobante $comprobante)
    {
        //$temporals = Comprobante_Product::where('comprobante_id', $comprobante->id)->get();

        /* $temporal = [
            'company_id' => '',
            'product_id' => '',
            'codigobarras' => '',
            'employee_id' => '',
            'image' => '',
            'name' => '',
            'um' => '',
            'tipafeigv' => '',
            'saleprice' => '',
            'mtovalorunitario' => '',
            'porcentajeigv' => '',
            'factoricbper' => '',
            'discount' => '',
            'salepricef' => '',
            'quantity' => '',
            'subtotal' => '',
            'igv' => '',
            'totalimpuestos' => '',
            'icbper' => '',
            'mtovalorventa' => '',
            'mtobaseigv' => '',
            'esbolsa' => '',
        ]; */

        //$detalles = Comprobante_Product::where('comprobante_id', $comprobante->id)->get();
        //dd($detalles);
       /*  foreach($detalles as $detalle){
            $this->temporal['company_id'][] = $detalle->company_id;
            $this->temporal['product_id'][] = $detalle->product_id;
            $this->temporal['codigobarras'][] = $detalle->codigobarras;
            $this->temporal['employee_id'][] = $detalle->comprobante->employee_id;
            $this->temporal['name'][] = $detalle->product->um->abbreviation;
            $this->temporal['um'][] = $detalle->product->um->abbreviation;
            $this->temporal['tipafeigv'][] = $detalle->product->tipoafectacion->codigo;
            $this->temporal['saleprice'][] = $detalle->price;
            $this->temporal['quantity'][] = $detalle->cant;
            $this->temporal['subtotal'][] = $detalle->subtotal;
            $this->temporal['igv'][] = $detalle->igv;
            $this->temporal['totalimpuestos'][] = $detalle->totalimpuestos;
            $this->temporal['icbper'][] = $detalle->icbper;
            $this->temporal['mtovalorventa'][] = $detalle->mtovalorventa;
            $this->temporal['mtobaseigv'][] = $detalle->mtobaseigv;
            $this->temporal['esbolsa'][] = $detalle->product->esbolsa;

        } */

       //dd($this->temporal);
       //$temporalCollection = collect($this->temporal);

        /* $temporals = Comprobante::with(['products' => function ($query) {
            $query->select('products.id', 'products.codigobarras', 'products.name', 'products.um_id', 'products.saleprice', 'products.mtovalorunitario', 'products.tipoafectacion_id')
                ->withPivot('cant', 'price', 'mtobaseigv', 'igv', 'icbper', 'totalimpuestos', 'mtovalorventa', 'company_id')
                ->addSelect('comprobante_producto.cant', 'comprobante_producto.subtotal', 'comprobante_producto.price', 'comprobante_producto.icbper')
                ->where('comprobante_producto.company_id', '=', auth()->user()->company_id);
        }])
        ->where('comprobantes.id', $comprobante->id)
        ->select('comprobantes.id', 'products.id','comprobantes.company_id', 'comprobantes.employee_id', 'comprobantes.serienumero')
        ->get(); */


        /* $temporals = Comprobante::with(['products' => function ($query) use ($comprobante) {
            $query->select('products.id as product_id', 'products.codigobarras', 'products.name', 'products.um_id', 'products.saleprice', 'products.mtovalorunitario', 'products.tipoafectacion_id')
                ->withPivot('cant', 'price', 'mtobaseigv', 'igv', 'icbper', 'totalimpuestos', 'mtovalorventa', 'company_id')
                ->addSelect('comprobante_producto.cant', 'comprobante_producto.subtotal', 'comprobante_producto.price', 'comprobante_producto.icbper')
                ->where('comprobante_producto.company_id', auth()->user()->company_id);
        }])
        ->where('comprobantes.id', $comprobante->id)
        ->select('comprobantes.id as comprobante_id','comprobantes.company_id', 'comprobantes.employee_id', 'comprobantes.serienumero')
        ->get(); */

        //como las consultas no funcan construiremos un array de tempotal

        /* $temporals = Temporal::where('company_id', auth()->user()->employee->company->id)
        ->where('employee_id', auth()->user()->employee->id)->get(); */

        $temporals = Temporal::where('company_id', auth()->user()->employee->company->id)
        ->where('employee_id', auth()->user()->employee->id)
        ->where('state',1)
        ->where('comprobante_id', $comprobante->id)->get();//state 0 tiene los temporales actuales, 1 ya esta grabado pero no enviado a sunat


        $sunat = new SunatService($comprobante, $this->company, $temporals, $comprobante->factura);

        $sunat->getSee();
        $sunat->setInvoice();
        $sunat->send(); //send es el metodo de greenter
        $temporals->each->delete();//eliminamos del temporal porque ya se envio a Sunat
        $this->emit('alert', 'El comprobante se envio a sunat');

    }


}
