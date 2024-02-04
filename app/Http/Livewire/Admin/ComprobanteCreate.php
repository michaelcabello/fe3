<?php

namespace App\Http\Livewire\Admin;

use Carbon\Carbon;
use App\Models\Local;
use App\Models\Boleta;
use App\Models\Company;
use App\Models\Product;
use Livewire\Component;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Temporal;
use App\Models\Comprobante;
use App\Models\Comprobante_Product;
use GuzzleHttp\Promise\Create;
use App\Models\Tipocomprobante;
use Illuminate\Support\Collection;
use App\Models\Local_tipocomprobante;
use App\Services\SunatService;

class ComprobanteCreate extends Component
{
    //public $msg = '';
    //public $itemsQuantity;
    //public $company;
    public $customer_id = "", $local_id = "", $tipocomprobante_id = "", $local_tipocomprobante_id, $company_id, $employee_id, $fechaemision, $nota;
    public $serie, $numero, $serienumero, $fechavencimiento, $total, $comprobante_id, $paymenttype_id = "", $currency_id = "";
    public $moneda;
    public $subtotal, $igv, $tipodecambio_id;
    public $search, $boleta;


    public $tipoOperacion = '0101'; //Catálogo No. 51: Código de tipo de operación 0101 venta interna
    public $tipoDoc = ''; //factura boleta $tipocomprobante_id
    //public $serie = '';
    public $correlativo = ''; //$numero
    public $fechaEmision = ''; //$fechaemision
    public $formaPago = [
        'tipo' => 'Contado', //$paymenttype_id
    ];

    public $tipoMoneda = "PEN"; //$currency_id

    public $client =  [
        'tipoDoc' => '6',
        'numDoc' => '',
        'rznSocial' => '',
        'address' => [
            'direccion' => '',
        ]
    ];

    public $company = [];

    //Montos
    public $mtoOperGravadas = 0;
    public $mtoOperExoneradas = 0;
    public $mtoOperInafectas = 0;
    public $mtoOperExportacion = 0;
    public $mtoOperGratuitas = 0;
    /* 'mtoBaseIvap' => 0, */


    //Impuestos
    public $mtoIGV = 0;
    public $mtoIGVGratuitas = 0;
    /* 'mtoIvap' => 0, */
    public $icbper = 0;
    public $totalImpuestos = 0;

    //Totales
    public $valorVenta = 0;
    public $subTotal = 0;
    public $redondeo = 0;
    public $mtoImpVenta = 0;

    //Productos
    public $details = [];

    //Leyendas
    public $legends = [
        [
            'code' => '1000',
            'value' => 'CERO  CON 00/100',
        ]
    ];

    public $branch_id = '';




    public $item = [
        'codProducto' => '',
        'unidad' => 'NIU',
        'descripcion' => '',

        //Cantidad de items
        'cantidad' => 1,

        // Valor gratuido
        'mtoValorGratuito' => "0.000",

        //Valor unitario sin igv
        'mtoValorUnitario' => "0.000",

        // Valor unitario con igv
        'mtoPrecioUnitario' => "0.000",

        //mtoValorUnitario * cantidad
        'mtoBaseIgv' => "0.000",

        //Porcentaje de igv
        'porcentajeIgv' => 18,

        //mtoBaseIgv * porcentajeIgv / 100
        'igv' => "0.000",

        //Impuesto por bolsa plastica
        'factorIcbper' => "0.000",

        //factorIcbper * cantidad
        'icbper' => "0.000",

        // Gravado Op. Onerosa - Catalog. 07
        'tipAfeIgv' => 10,

        // igv + icbper
        'totalImpuestos' => "0.000",

        // mtoValorUnitario * cantidad
        'mtoValorVenta' => "0.000",
    ];




    //public $salesCartInstance = 'salesCart';
    //public $carts = [];
    protected $listeners = ['delete', 'limpiar'];

    public function mount()
    {
        //$this->fechaemision = Carbon::now();
        //$this->fechaemision = Carbon::now()->format('d m Y');
        $this->fechaemision = Carbon::now()->format('Y-m-d'); //Y-m-d es el formato en el cual se guardara en la BD, la vista mostrara dd/mm/yyy es por el navegadory la configuracion de la pc pero al escoger la fecha automaticamente lo convierte a Y-m-d y lo guarda en la BD


        /* $this->moneda = Currency::where('default', 1)
        ->value('abbreviation'); */
        //$this->moneda = Company::where('id', $numero)->where('currency_id', );
        $this->currency_id = auth()->user()->employee->company->currency_id; //$this->currency_id  hace que en la lista de currencies muestre por defecto soles por ejemplo
        $this->moneda = auth()->user()->employee->company->currency->abbreviation;
        $this->company = auth()->user()->employee->company;

        //$this->moneda = Currency::find($this->currency_id)->abbreviation;

        //$this->currency_id = $currency;

    }



    public function ScanCode($barcode,  $quantity = 1)
    {
        $this->search = $barcode;
        $company_id = auth()->user()->employee->company->id;
        //dd($company_id);
        //buscamos productos de la empresa
        $product = Product::where('company_id', $company_id)->where('codigobarras', $this->search)->first();

        if (!$product) {
            //session()->flash('alert', 'El producto no está registrado');
            //$this->msg = 'El producto no registrado';

            //dd($this->msg);
            //$this->emit('alert', $this->msg);
            //$title = 'El producto no está registrado';
        } elseif (!isset($product->saleprice)) {
            // $this->msg = 'El producto no tiene precio';
            // $this->emit('alert', $this->msg);
        } else {

            $this->addToCartbd(
                $product->id,
                $product->codigobarras,
                $product->name,
                $product->saleprice,
                $quantity
            );

            $this->total = $this->getTotalFromTemporals();
        }
    }

    public function addToCartbd($product_id, $codigobarras, $name, $saleprice, $quantity) //productId  captura al codigobarras
    {
        $company_id = auth()->user()->employee->company->id;
        //buscamos el producto en el carrito osea en la tabla temporal
        $productotemporal = Temporal::where('company_id', $company_id)->where('codigobarras', $codigobarras)->where('employee_id', auth()->user()->employee->id)->first();
        //dd($producto);
        //si el producto existe actualizamos la cantidad
        if ($productotemporal) { //busca en el campo id de la coleccion
            $newQuantity = $productotemporal->quantity + $quantity;
            $newSubtotal = $newQuantity * $saleprice;

            $productotemporal->update([
                'quantity' => $newQuantity,
                'subtotal' => $newSubtotal,
            ]);
        } else { //si el producto no esta en temporal lo creamos

            $subtotal = $quantity * $saleprice;

            Temporal::Create([
                'company_id' => $company_id,
                'employee_id' => auth()->user()->employee->id,
                'product_id' => $product_id,
                'codigobarras' => $codigobarras,
                'name' => $name,
                'saleprice' => $saleprice,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
                // 'subtotal' => $saleprice*1,
                //'image' => $image,
            ]);
        }
    }

    public function getTotalFromTemporals()
    {
        $company_id = auth()->user()->employee->company->id;

        // Obtener el total de la tabla temporals para la empresa actual
        $this->total = Temporal::where('company_id', $company_id)
            ->where('employee_id', auth()->user()->employee->id)
            ->sum('subtotal');

        return $this->total;
    }



    // actualizar cantidad item en carrito
    public function updateQty($id, $saleprice, $quantity = 1)
    {
        if ($quantity <= 0)
            $this->removeItem($id);
        else
            $this->updateQuantity($id, $saleprice, $quantity);
    }

    public function delete(Temporal $temporal)
    {
        //$this->authorize('update', $brand);
        $temporal->delete();
        $this->total = $this->getTotalFromTemporals();
    }


    public function removeItem($id)
    {
        $registro = Temporal::find($id);
        if ($registro) {
            // Si se encontró el modelo, eliminarlo
            $registro->delete();
            $this->total = $this->getTotalFromTemporals();
        }
    }



    public function updateQuantity($id, $saleprice, $quantity)
    {
        $subtotal = $quantity * $saleprice;

        if ($saleprice > 0 and $quantity > 0) {
            $productelegido = Temporal::where('id', $id)->first();
            $productelegido->update([
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ]);
        }

        $this->total = $this->getTotalFromTemporals();
    }




    public function updatePrice($id, $saleprice, $quantity)
    {
        $subtotal = $quantity * $saleprice;
        if ($saleprice > 0 and $quantity > 0) {
            $productelegido = Temporal::where('id', $id)->first();
            $productelegido->update([
                'saleprice' => $saleprice,
                'subtotal' => $subtotal,
            ]);
        }

        $this->total = $this->getTotalFromTemporals();
    }

    public function limpiar()
    {
        Temporal::where('company_id', auth()->user()->employee->company->id)
            ->where('employee_id', auth()->user()->employee->id)
            ->delete();
    }


    public function updatedCurrencyId($value)
    {
        // $this->moneda = Currency::where('id', $value);
        $this->moneda = Currency::where('id', $value)->value('abbreviation');
    }

    //tipocomprobante_id

    public function updatedTipocomprobanteId($value)
    {
        // $this->moneda = Currency::where('id', $value);
        //$this->serie = Currency::where('id', $value)->value('abbreviation');
        // Lógica para actualizar el campo "Serie" cuando cambia el comprobante seleccionado
        // Puedes personalizar esta lógica según tus necesidades

        $local = auth()->user()->employee->local;

        //dd($this->tc = $local->tipocomprobantes);  se obtiene la tabla tipocomprobantes pero que son de local logueado
        // Obtener la serie a través de la relación muchos a muchos
        $this->serie = $local->tipocomprobantes
            ->where('id', $value)
            ->first()
            ->pivot
            ->serie ?? "null";

        switch ($value) {
            case 1:
                $company_id = auth()->user()->employee->company->id;
                /* $lastBoleta = Boleta::where('company_id', $company_id)
                    ->where('serie', $this->serie)
                    ->latest('numero')
                    ->first();

                if ($lastBoleta) {
                    $this->numero = $lastBoleta->numero;
                }

                $this->numero = 1;
                break; */

                $lastBoleta = Boleta::where('company_id', $company_id)
                    ->where('serie', $this->serie)
                    ->latest('numero')
                    ->first();

                $this->numero = $lastBoleta ? $lastBoleta->numero : 1;
                break;


            case 2:
                /* $company_id = auth()->user()->employee->company->id;
                $lastBoleta = Factura::where('company_id', $company_id)
                    ->where('serie', $this->serie)
                    ->latest('numero')
                    ->first();

                if ($lastBoleta) {
                    $this->numero = $lastBoleta->numero;
                } */

                $this->numero = 1;
                break;

            case 3:
                $this->numero = 300;
                break;
            default:
                // Manejo por defecto si $value no coincide con ninguno de los casos anteriores
                break;
        }
    }

    protected $rules = [
        'customer_id' => 'required',
        'tipocomprobante_id' => 'required',
        'paymenttype_id' => 'required',
        'fechaemision' => 'required|date',
        //'fechavencimiento' => 'required|date|before_or_equal:fechaemision',
        'fechavencimiento' => 'required|date|after_or_equal:fechaemision',
        'currency_id' => 'required',
        'serie' => 'required',
        'numero' => 'required',
    ];


    //guardamos el comprobante
    public function save()
    {

        $this->validate();

        // Validación de que la fecha de vencimiento sea mayor o igual a la fecha de emisión
        $this->local_id = auth()->user()->employee->local->id;

        $this->local_tipocomprobante_id = Local_tipocomprobante::where('local_id', $this->local_id)->where('tipocomprobante_id', $this->tipocomprobante_id)->value('id');

        /* $this->fechaemision = Carbon::createFromFormat('d m Y', $this->fechaemision)->format('Y-m-d');
        $this->fechavencimiento = Carbon::createFromFormat('d m Y', $this->fechavencimiento)->format('Y-m-d'); */

        //$this->fechaemision = Carbon::createFromFormat('d-m-Y', $this->fechaemision)->format('Y-m-d');
        //$this->fechavencimiento = Carbon::createFromFormat('d-m-Y', $this->fechavencimiento)->format('Y-m-d');
        //$this->fechaemision = Carbon::createFromFormat('d/m/Y', $this->fechaemision)->format('Y-m-d');

        // dd($this->fechaemision);

        /*  $this->fechaemision = Carbon::createFromFormat('d/m/Y', $this->fechaemision)->format('Y-m-d');
        $this->fechavencimiento = Carbon::createFromFormat('d/m/Y', $this->fechavencimiento)->format('Y-m-d'); */
        $this->serienumero = $this->serie . "-" . $this->numero;
        //dd($this->serienumero);

        //guadamos la tabla comprobantes
        $comprobante = Comprobante::create([
            'customer_id' => $this->customer_id,
            'local_id' => $this->local_id,
            'tipocomprobante_id' => $this->tipocomprobante_id,
            'local_tipocomprobante_id' => $this->local_tipocomprobante_id,
            'company_id' => auth()->user()->employee->company->id, //encontramos la company actual osea la compania del usuario logueado
            'employee_id' => auth()->user()->employee->id,
            'fechaemision' =>  $this->fechaemision,
            'nota' => $this->nota,
        ]);
        //guadamos la tabla boletas
        Boleta::create([
            'serie' => $this->serie,
            'numero' => $this->numero,
            'serienumero' => $this->serienumero,
            'fechavencimiento' => $this->fechavencimiento,
            'total' => $this->total,
            'comprobante_id' => $comprobante->id,
            'company_id' => auth()->user()->employee->company->id,
            'paymenttype_id' => $this->paymenttype_id,
            'currency_id' => $this->currency_id,
            'tipodecambio_id' => 1,

        ]);

        //guadamos la tabla comprobante_product
        //lo comente porque accede muchas veces a la BD
        /*  $temporals = Temporal::where('company_id', auth()->user()->employee->company->id)
            ->where('employee_id', auth()->user()->employee->id)->get();

        foreach ($temporals as $temporal) {
            Comprobante_Product::create([
                'cant' => $temporal->quantity,
                'price' => $temporal->saleprice,
                'subtotal' => $temporal->subtotal,
                'product_id' => $temporal->product_id,
                'comprobante_id' => $comprobante->id,
            ]);
        }
        $temporals->each->delete(); */

        //guadamos la tabla comprobante_product

        $temporals = Temporal::where('company_id', auth()->user()->employee->company->id)
            ->where('employee_id', auth()->user()->employee->id)
            ->get();

        $comprobanteProductData = $temporals->map(function ($temporal) use ($comprobante) {
            return [
                'cant' => $temporal->quantity,
                'price' => $temporal->saleprice,
                'subtotal' => $temporal->subtotal,
                'product_id' => $temporal->product_id,
                'comprobante_id' => $comprobante->id,
            ];
        });

        Comprobante_Product::insert($comprobanteProductData->toArray());

        $temporals->each->delete();


        //facturacion electronica
        $sunat = new SunatService($this->invoice, $this->company);
        $sunat->getSee();
        $sunat->setInvoice();




        //$this->emitTo('admin.comprobante-list', 'render');

        $this->emit('alert', 'El comprobante se creo correctamente');

        return redirect()->route('admin.sale.index');






        //eliminar el temporal


        //enviar mensaje de guardado


    }


    /*  public function fechaemision($selectedDate)
    {
        $this->fechaemision = $selectedDate;
    } */

    public function render()
    {

        $company_id = auth()->user()->employee->company->id;

        $cart = Temporal::where('company_id', $company_id)->where('employee_id', auth()->user()->employee->id)->get();

        //dd($cart);

        $customers = Customer::all();
        $currencies = Currency::all();


        $tipocomprobantes = auth()->user()->employee->local->tipocomprobantes;
        //dd($tipocomprobantes);

        $this->total = $this->getTotalFromTemporals();

        return view('livewire.admin.comprobante-create', compact('customers', 'currencies', 'tipocomprobantes', 'cart'));
    }
}
