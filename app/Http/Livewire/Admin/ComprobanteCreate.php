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
use Luecano\NumeroALetras\NumeroALetras;

class ComprobanteCreate extends Component
{
    //public $msg = '';
    //public $itemsQuantity;
    public $company;
    public $customer_id = "", $local_id = "", $tipocomprobante_id = "", $local_tipocomprobante_id, $company_id, $employee_id, $fechaemision, $nota;
    public $serie, $numero, $serienumero, $fechavencimiento, $total, $comprobante_id, $paymenttype_id = "", $currency_id = "";
    public $moneda;
    public $subtotal, $igv, $tipodecambio_id;
    public $search, $boleta;


    public $invoice = [
        //ublversion estoy poniendo en company oseaesta guardado en companies
        'tipoOperacion' => '0101', //Catálogo No. 51: Código de tipo de operación 0101 venta interna tabla tipodeoperacions, se guardara en comprobantes
        'tipoDoc' => '', //$tipocomprobante_id = ""   01 es factura  tabla tipocomprobantes//seguarda en la tabla comprobantes
        'serie' => 'F001', //$serie//se guarda en la tabla boletas facturas
        'correlativo' => '16', //$numero//se guarda en la tabla boletas facturas //se guarda en la tabla comprobantes
        'fechaEmision' => '2023-08-24 13:05:00-05:00', //$fechaemision //se guarda en la tabla comprobantes
        'formaPago' => [
            'tipo' => 'Contado', //$paymenttype_id debo enviar contado o credito en letras
        ],

        'tipoMoneda' => 'PEN', //$currency_id = ""  Catalog. 02

        'client' => [
            'tipoDoc' => '6', //6 es ruc 1 es dni  tabla codigos de tipos de documentos de identidad
            'numDoc' => '20000000001',
            'rznSocial' => 'ABC SRL',
            'address' => [
                'direccion' => '',
            ],
        ],

        'company' => [],

        //Montos
        'mtoOperGravadas' => 0,
        'mtoOperExoneradas' => 0,
        'mtoOperInafectas' => 0,
        'mtoOperExportacion' => 0,
        'mtoOperGratuitas' => 0,
        /* 'mtoBaseIvap' => 0, */

        //Impuestos
        'mtoIGV' => 0,
        'mtoIGVGratuitas' => 0,
        'icbper' => 0,
        'totalImpuestos' => 0,

        //Totales
        'valorVenta' => 0,
        'subTotal' => 0,
        'redondeo' => 0,
        'mtoImpVenta' => 0,

        //Productos
        'details' => [],

        //Leyendas
        'legends' => [
            [
                'code' => '1000',
                'value' => 'CERO  CON 00/100',
            ]
        ],

        'branch_id' => ''
    ];

    public $item = [
        'codProducto' => '',//esta en la tabla productos //cod producto y obtienes el resto//guardar producto base + igv
        'unidad' => 'NIU',//esta en la tabla productos
        'descripcion' => '',//esta en la tabla productos

        //Cantidad de items
        'cantidad' => 1,//se guardara en la tabla detalles

        // Valor gratuido
        'mtoValorGratuito' => "0.000",//esta  en la tabla productos

        //Valor unitario sin igv
        'mtoValorUnitario' => "0.000",//esta  en la tabla productos

        // Valor unitario con igv
        'mtoPrecioUnitario' => "0.000",//esta en la tabla productos

        //mtoValorUnitario * cantidad
        'mtoBaseIgv' => "0.000",//al final guardaremos en el detalle

        //Porcentaje de igv
        'porcentajeIgv' => 18, //esta en la tabla impuestos lo jalaremos no guardaremos en la tabla detalles

        //mtoBaseIgv * porcentajeIgv / 100
        'igv' => "0.000", // guardaremos en la tabla detalles

        //Impuesto por bolsa plastica
        'factorIcbper' => "0.000",

        //factorIcbper * cantidad
        'icbper' => "0.000",

        // Gravado Op. Onerosa - Catalog. 07
        'tipAfeIgv' => 10, //esta en la tabla catalogo 07 tipo de venta lo sacamos de la tabla productos no guardamos en detalles

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

        $tipocomprobantes = auth()->user()->employee->local->tipocomprobantes;
        // Encuentra el tipo de comprobante seleccionado
        $selectedTipoComprobante = $tipocomprobantes->where('id', $value)->first();

        // Actualiza el valor de tipoDoc en tu array de invoice
        $this->invoice['tipoDoc'] = $selectedTipoComprobante->codigo;


        //dd($selectedTipoComprobante->codigo);


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

        $this->invoice['serie'] = $this->serie;
        //dd($this->invoice['serie']);


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



    public function getTotales()
    {
        $this->invoice['mtoOperGravadas'] = collect($this->invoice['details'])
            ->where('tipAfeIgv', '10')
            ->sum('mtoValorVenta');

        $this->invoice['mtoOperExoneradas'] = collect($this->invoice['details'])
            ->where('tipAfeIgv', '20')
            ->sum('mtoValorVenta');

        $this->invoice['mtoOperInafectas'] = collect($this->invoice['details'])
            ->where('tipAfeIgv', '30')
            ->sum('mtoValorVenta');

        $this->invoice['mtoOperExportacion'] = collect($this->invoice['details'])
            ->where('tipAfeIgv', '40')
            ->sum('mtoValorVenta');

        $this->invoice['mtoOperGratuitas'] = collect($this->invoice['details'])
            ->whereNotIn('tipAfeIgv', ['10', '20', '30', '40'])
            ->sum('mtoValorVenta');

        $this->invoice['mtoIGV'] = collect($this->invoice['details'])
            ->whereIn('tipAfeIgv', ['10', '20', '30', '40'])
            ->sum('igv');

        $this->invoice['mtoIGVGratuitas'] = collect($this->invoice['details'])
            ->whereNotIn('tipAfeIgv', ['10', '20', '30', '40'])
            ->sum('igv');

        $this->invoice['icbper'] = collect($this->invoice['details'])
            ->sum('icbper');

        $this->invoice['totalImpuestos'] = $this->invoice['mtoIGV'] + $this->invoice['icbper'];

        /* Totales */
        $this->invoice['valorVenta'] = collect($this->invoice['details'])
            ->whereIn('tipAfeIgv', ['10', '20', '30', '40'])
            ->sum('mtoValorVenta');

        $this->invoice['subTotal'] = $this->invoice['valorVenta'] + $this->invoice['totalImpuestos'];

        $this->invoice['mtoImpVenta'] = floor($this->invoice['subTotal'] * 10) / 10;

        $this->invoice['redondeo'] =  $this->invoice['subTotal'] - $this->invoice['mtoImpVenta'];
    }

    public function getLegends()
    {
        $formatter = new NumeroALetras();

        $legends = [];

        $legends[] = [
            'code' => '1000',
            'value' => $formatter->toInvoice($this->invoice['mtoImpVenta'], 2)
        ];

        if (collect($this->invoice['details'])->whereNotIn('tipAfeIgv', ['10', '20', '30', '40'])->count()) {
            $legends[] = [
                'code' => '1002',
                'value' => 'TRANSFERENCIA GRATUITA DE UN BIEN Y/O SERVICIO PRESTADO GRATUITAMENTE'
            ];
        }

        if ($this->invoice['tipoOperacion'] == '1001') {
            $legends[] = [
                'code' => '2006',
                'value' => 'Operación sujeta a detracción'
            ];
        }

        $this->invoice['legends'] = $legends;
    }


    //guardamos el comprobante
    public function save()
    {

        //dd($this->company);
        $this->validate();



        $this->invoice['fechaEmision'] = $this->fechaemision;
        if ($this->paymenttype_id == 1) {
            $this->invoice['formapago']['tipo'] = "contado";
        } elseif (($this->paymenttype_id == 2)) {
            $this->invoice['formapago']['tipo'] = "credito";
        }


        if ($this->paymenttype_id == 1) {
            $this->invoice['tipoMoneda'] = "PEN";
        } elseif ($this->paymenttype_id == 2) {
            $this->invoice['tipoMoneda'] = "USD";
        }

        $this->invoice['client']['tipoDoc'] = "RUC";
        $this->invoice['client']['numDoc'] = 20447393303;
        $this->invoice['client']['rznSocial'] = "BTECPERU SRL";

        $this->invoice['company']['ruc'] = auth()->user()->employee->company->ruc;
        $this->invoice['company']['razonSocial'] = auth()->user()->employee->company->razonsocial;
        $this->invoice['company']['nombreComercial'] = auth()->user()->employee->company->nombrecomercial;

        $this->invoice['company']['address']['ubigeo'] = auth()->user()->employee->company->ubigeo;
        $this->invoice['company']['address']['provincia'] = "Lima";
        $this->invoice['company']['address']['departamento'] = "Lima";
        $this->invoice['company']['address']['distrito'] = "Lima";
        $this->invoice['company']['address']['urbanizacion'] = "Santa Beatriz";
        $this->invoice['company']['address']['direccion'] = auth()->user()->employee->company->direccion;
        $this->invoice['company']['address']['codLocal'] = auth()->user()->employee->local->anexo;




        //dd($this->invoice['company']['address']['codLocal']);


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
        $temporals = Temporal::where('company_id', auth()->user()->employee->company->id)
            ->where('employee_id', auth()->user()->employee->id)->get();

        foreach ($temporals as $temporal) {
            //si el producto es bolsa agregar icbper de lo contrario no///////////////////////////////
            //$this->invoice['details'][] = $this->item;
            $this->item['codProducto'] = $temporal->codigobarras;
            $this->item['unidad'] = "NIU";
            $this->item['descripcion'] = $temporal->name;
            $this->item['cantidad'] = $temporal->quantity;
            $this->item['mtoValorGratuito'] = 0;
            $this->item['mtoValorUnitario'] = $temporal->saleprice / 1.18;  //monto sin inc igv
            $this->item['mtoPrecioUnitario'] = $temporal->saleprice; //precio con igv
            $this->item['mtoBaseIgv'] = ($temporal->saleprice / 1.18) * $temporal->quantity; //cantidad * precio sin igv
            $this->item['porcentajeIgv'] = 18; //porcentaje en numeros 18%
            $this->item['igv'] = $temporal->subtotal - $temporal->subtotal / 1.18;
            $this->item['factorIcbper'] = 0.2;
            $this->item['icbper'] = $temporal->quantity * (0.2);
            $this->item['tipAfeIgv'] = 10;
            $this->item['totalImpuestos'] = $temporal->quantity * (0.2) + ($temporal->subtotal - $temporal->subtotal / 1.18);
            $this->item['mtoValorVenta'] = ($temporal->saleprice / 1.18) * $temporal->quantity;


            //me falta dar valores a los items

            //dd($this->item);
            $this->invoice['details'][] = $this->item;



            Comprobante_Product::create([
                'cant' => $temporal->quantity,
                'price' => $temporal->saleprice,
                'subtotal' => $temporal->subtotal,
                'product_id' => $temporal->product_id,
                'comprobante_id' => $comprobante->id,
            ]);
        }

        $this->getTotales();
        $this->getLegends();

        $temporals->each->delete();

        //guadamos la tabla comprobante_product

        /* $temporals = Temporal::where('company_id', auth()->user()->employee->company->id)
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

        $temporals->each->delete(); */


        //facturacion electronica
        $sunat = new SunatService($this->invoice, $this->company);

        $sunat->getSee();
        $sunat->setInvoice();
        $sunat->send();

        /* $xml = $this->see->getFactory()->getLastXml();
        $this->invoice['xml'] = $this->see->getFactory()->getLastXml();
        $this->invoice['hash'] = (new XmlUtils())->getHashSign($xml);

       dd($this->invoice); */


        //$this->emitTo('admin.comprobante-list', 'render');

        $this->emit('alert', 'El comprobante se creo correctamente');

        return redirect()->route('admin.comprobante.list');






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
