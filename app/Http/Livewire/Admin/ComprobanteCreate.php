<?php

namespace App\Http\Livewire\Admin;

use Carbon\Carbon;
use App\Models\Local;
use App\Models\Boleta;
use App\Models\Company;
use App\Models\Factura;
use App\Models\Product;
use Livewire\Component;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\District;
use App\Models\Impuesto;
use App\Models\Province;
use App\Models\Temporal;
use App\Models\Department;
use App\Models\Comprobante;
use Illuminate\Support\Str;
use App\Models\Tipodocumento;
use App\Services\SunatService;
use GuzzleHttp\Promise\Create;
use App\Models\Tipocomprobante;
use App\Models\Tipodeoperacion;
use Illuminate\Support\Collection;
use App\Models\Comprobante_Product;
use App\Models\Local_tipocomprobante;
use Luecano\NumeroALetras\NumeroALetras;

class ComprobanteCreate extends Component
{
    //public $msg = '';
    //public $itemsQuantity;
    public $company;
    public $tipodocumento_id = "", $customer_id = "", $local_id = "", $tipocomprobante_id = "", $local_tipocomprobante_id, $company_id, $employee_id, $fechaemision, $nota;
    public $serie, $numero, $serienumero, $fechavencimiento, $total, $comprobante_id, $paymenttype_id = "", $currency_id = "";
    public $moneda;
    public $subtotal, $tipodecambio_id;
    public $search, $boleta;
    public $factoricbper, $igv;
    public $mtoopergravadas, $mtooperexoneradas, $mtooperinafectas, $mtooperexportacion, $mtoopergratuitas, $mtoigv, $mtoigvgratuitas, $icbper, $totalimpuestos;
    public $valorventa, $subtotall, $mtoimpventa, $redondeo, $legends;
    public $totalenletras;
    public $detraccion, $tipodeoperacion_id = "", $tipodeoperacion_codigo = "";
    public $sending_method = 1;
    public $razon_social;
    public $ruc;
    public $nombre_comercial;
    public $direccion;
    public $departamento, $provincia, $distrito;
    public $isDocumentTypeSelected = false;
    public $monedadescription;

    //public $salesCartInstance = 'salesCart';
    //public $carts = [];
    protected $listeners = ['delete', 'limpiar'];

    public $searchh = "";

    public function mount()
    {
        $this->tipodeoperacion_id = "1";
        //$this->fechaemision = Carbon::now();
        //$this->fechaemision = Carbon::now()->format('d m Y');
        $this->fechaemision = Carbon::now()->format('Y-m-d'); //Y-m-d es el formato en el cual se guardara en la BD, la vista mostrara dd/mm/yyy es por el navegadory la configuracion de la pc pero al escoger la fecha automaticamente lo convierte a Y-m-d y lo guarda en la BD

        $this->igv = Impuesto::where('siglas', 'IGV')->value('valor'); //es el 18%
        $this->factoricbper = Impuesto::where('siglas', 'ICBPER')->value('valor'); //es 0.2
        /* $this->moneda = Currency::where('default', 1)
        ->value('abbreviation'); */
        //$this->moneda = Company::where('id', $numero)->where('currency_id', );
        $this->currency_id = auth()->user()->employee->company->currency_id; //$this->currency_id  hace que en la lista de currencies muestre por defecto soles por ejemplo
        $this->moneda = auth()->user()->employee->company->currency->abbreviation ?? 'Sol';
        $this->monedadescription = auth()->user()->employee->company->currency->description ?? 'Soles';
        $this->company = auth()->user()->employee->company;

        $this->company_id = auth()->user()->employee->company->id; //compañia logueaada
        //$this->moneda = Currency::find($this->currency_id)->abbreviation;
        //$this->currency_id = $currency;
    }



    function removeAccents($text)
    {
        $unwanted_array = array(
            'Á' => 'A', 'À' => 'A', 'Â' => 'A', 'Ä' => 'A', 'Ã' => 'A', 'Å' => 'A', 'Ā' => 'A',
            'Ă' => 'A', 'Ą' => 'A', 'á' => 'a', 'à' => 'a', 'â' => 'a', 'ä' => 'a', 'ã' => 'a',
            'å' => 'a', 'ā' => 'a', 'ă' => 'a', 'ą' => 'a', 'É' => 'E', 'È' => 'E', 'Ê' => 'E',
            'Ë' => 'E', 'Ē' => 'E', 'Ĕ' => 'E', 'Ė' => 'E', 'Ę' => 'E', 'Ě' => 'E', 'é' => 'e',
            'è' => 'e', 'ê' => 'e', 'ë' => 'e', 'ē' => 'e', 'ĕ' => 'e', 'ė' => 'e', 'ę' => 'e',
            'ě' => 'e', 'Í' => 'I', 'Ì' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ĩ' => 'I', 'Ī' => 'I',
            'Ĭ' => 'I', 'Į' => 'I', 'İ' => 'I', 'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i',
            'ĩ' => 'i', 'ī' => 'i', 'ĭ' => 'i', 'į' => 'i', 'ı' => 'i', 'Ó' => 'O', 'Ò' => 'O',
            'Ô' => 'O', 'Ö' => 'O', 'Õ' => 'O', 'Ø' => 'O', 'Ō' => 'O', 'Ŏ' => 'O', 'Ő' => 'O',
            'ó' => 'o', 'ò' => 'o', 'ô' => 'o', 'ö' => 'o', 'õ' => 'o', 'ø' => 'o', 'ō' => 'o',
            'ŏ' => 'o', 'ő' => 'o', 'Ú' => 'U', 'Ù' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ũ' => 'U',
            'Ū' => 'U', 'Ŭ' => 'U', 'Ů' => 'U', 'Ű' => 'U', 'Ų' => 'U', 'ú' => 'u', 'ù' => 'u',
            'û' => 'u', 'ü' => 'u', 'ũ' => 'u', 'ū' => 'u', 'ŭ' => 'u', 'ů' => 'u', 'ű' => 'u',
            'ų' => 'u', 'Ý' => 'Y', 'Ÿ' => 'Y', 'Ŷ' => 'Y', 'ý' => 'y', 'ÿ' => 'y', 'ŷ' => 'y',
            'Ç' => 'C', 'Č' => 'C', 'Ć' => 'C', 'Ĉ' => 'C', 'Ċ' => 'C', 'ç' => 'c', 'č' => 'c',
            'ć' => 'c', 'ĉ' => 'c', 'ċ' => 'c', 'Ñ' => 'N', 'Ń' => 'N', 'Ň' => 'N', 'Ņ' => 'N',
            'Ŋ' => 'N', 'ñ' => 'n', 'ń' => 'n', 'ň' => 'n', 'ņ' => 'n', 'ŋ' => 'n', 'Š' => 'S',
            'Ś' => 'S', 'Ŝ' => 'S', 'Ş' => 'S', 'š' => 's', 'ś' => 's', 'ŝ' => 's', 'ş' => 's',
            'Ž' => 'Z', 'Ź' => 'Z', 'Ż' => 'Z', 'Ž' => 'Z', 'ž' => 'z', 'ź' => 'z', 'ż' => 'z',
            'ž' => 'z'
        );
        return strtr($text, $unwanted_array);
    }



    public function ScanCode($barcode,  $quantity = 1)
    {
        $this->search = $barcode;
        //$company_id = auth()->user()->employee->company->id;
        //buscamos productos de la empresa
        $product = Product::where('company_id', $this->company_id)->where('codigobarras', $this->search)->first();
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
                $product->image1,
                $product->um->abbreviation,
                $product->tipoafectacion->codigo,
                $product->saleprice,
                $product->mtovalorgratuito,
                $product->mtovalorunitario, //precio del producto sin igv
                $product->esbolsa,
                $quantity
            );
            //$this->total = $this->getTotalFromTemporals();
            $this->getTotales();
            $this->getLegends();
            $this->getTotalFromTemporals();
        }
    }


    public function getResultsProperty()
    {
        //$company_id = auth()->user()->employee->company->id;

        return Product::where('company_id', $this->company_id)->where('name', 'LIKE', '%' . $this->searchh . '%')
            ->where('state', 1)
            ->take(8)->get();
    }

    public function ScanCoded($codigo,  $quantity = 1)
    {
        //$this->searchh = $codigo;
        $id = $codigo;
        //$company_id = auth()->user()->employee->company->id;
        //buscamos productos de la empresa
        $product = Product::where('company_id', $this->company_id)->where('id', $id)->first();

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
                $product->image1,
                $product->um->abbreviation,
                $product->tipoafectacion->codigo,
                $product->saleprice,
                $product->mtovalorgratuito,
                $product->mtovalorunitario, //precio del producto sin igv
                $product->esbolsa,
                $quantity
            );
            //$this->total = $this->getTotalFromTemporals();
            $this->getTotales();
            $this->getLegends();
            $this->getTotalFromTemporals();
        }

        $this->searchh = null;
    }




    public function addToCartbd($product_id, $codigobarras, $name, $image, $um, $tipafeigv, $saleprice, $mtovalorgratuito, $mtovalorunitario, $esbolsa, $quantity) //productId  captura al codigobarras
    {
        $company_id = auth()->user()->employee->company->id;
        //buscamos el producto en el carrito osea en la tabla temporal
        $productotemporal = Temporal::where('company_id', $company_id)
            ->where('codigobarras', $codigobarras)
            ->where('employee_id', auth()->user()->employee->id)
            ->where('state', 0)
            ->first();
        //dd($productotemporal);
        //si el producto existe actualizamos la cantidad
        if ($productotemporal) { //busca en el campo id de la coleccion
            $newQuantity = $productotemporal->quantity + $quantity;
            $newSubtotal = $newQuantity * $saleprice; //incluye igv

            $mtovalorunitario = $saleprice / (1 + ($this->igv * 0.01)); //actualizamos//precio de producto sin inc igv ejemplo 100
            $mtobaseigv = $newQuantity * $mtovalorunitario; //cantidad * precio sin igv
            $icbper = $esbolsa == 1 ? ($newQuantity * $this->factoricbper) : 0; //$quantity * $this->factoricbper  ejemplo 5*0.2
            $igv = $newSubtotal - ($newQuantity * $mtovalorunitario); //es 118 -100= 18soles
            $totalimpuestos = $icbper + $igv;
            $mtovalorventa = $mtovalorunitario * $newQuantity; //subtotal sin inc IGV ejemplo 100 x 2 = 200
            //$this->saleprice = $saleprice;
            //dd($quantity*$mtovalorunitario);
            $productotemporal->update([
                'quantity' => $newQuantity,
                'saleprice' => $saleprice,
                'mtovalorunitario' => $mtovalorunitario, //precio de producto sin inc igv ejemplo 100
                'subtotal' => $newSubtotal, //incluido igv
                'mtobaseigv' => $mtobaseigv, //cantidad * precio sin igv
                'igv' => $igv, //es 118 -100= 18soles
                'icbper' => $icbper,
                'totalimpuestos' => $totalimpuestos,
                'mtovalorventa' => $mtovalorventa, //subtotal sin inc IGV ejemplo 100 x 2 = 200
            ]);
        } else { //si el producto no esta en temporal lo creamos

            $subtotal = $quantity * $saleprice; //subtotal incluye igv y es de 1 registro
            $icbper = $esbolsa == 1 ? ($quantity * $this->factoricbper) : 0; //$quantity * $this->factoricbper  ejemplo 5*0.2 //$esbolsa == 1 indica que es bolsa en la tabla products
            $igv = $subtotal - ($quantity * $mtovalorunitario); //es 118 -100= 18soles
            Temporal::Create([
                'company_id' => $company_id,
                'employee_id' => auth()->user()->employee->id,
                'image' => $image,
                'product_id' => $product_id,
                'codigobarras' => $codigobarras,
                'name' => $name,
                'um' => $um,
                'tipafeigv' => $tipafeigv, //esta en la tabla productos y no cambia, toma valores de 10 Gravado - Operación Onerosa tabla tipo afectacion del igv
                'saleprice' => $saleprice, //es precio de producto incluido igv  ejemplo 118, mtoPrecioUnitario
                'mtovalorgratuito' => $mtovalorgratuito,
                'mtovalorunitario' => $mtovalorunitario, //precio de producto sin inc igv ejemplo 100
                'mtobaseigv' => $quantity * $mtovalorunitario, //cantidad * precio sin igv
                'quantity' => $quantity,
                'porcentajeigv' => $this->igv,  //igv lo tenemos en el mount es 18%
                'subtotal' => $subtotal, //suntotal incluye igv
                'igv' => $igv, //ejemplo es es 118 -100= 18soles
                'factoricbper' => $this->factoricbper,  //factoricbper lo tenemos en el mount es 0.2
                //'icbper' => $quantity * $this->factoricbper,
                'icbper' => $icbper,
                'totalimpuestos' => $icbper + $igv,
                'mtovalorventa' => $mtovalorunitario * $quantity, //subtotal sin inc IGV ejemplo 100 x 2 = 200
                'esbolsa' => $esbolsa,
                'state' => 0,

                // 'subtotal' => $saleprice*1,
                //'image' => $image,
            ]);

            //$this->getTotales();
        }
    }


    public function searchRuc()
    {

        $tipodocumento = Tipodocumento::find($this->tipodocumento_id); //ruc , dni
        $numecar = Str::length($this->ruc); //calcula la longitud de ruc, dni, ce, etc..

        //si loescogido es 1(dni), 4, 6(ruc)
        switch ($tipodocumento->codigo) {
            case '1':
                //indicar 8 digitos dni
                if ($numecar != 8) {
                    $this->emit('alert', 'el DNI Debe tener 8 digitos');
                    return;
                }
                break;
            case '4':
                //carnet de extranjeria

                break;
            case '6':
                //ruc
                if ($numecar != 11) {
                    $this->emit('alert', 'el RUC Debe tener 11 digitos');
                    return;
                }
                break;
            default:

                break;
        }

        //primero buscaremos en Local
        //dd($this->ruc);
        $query = Customer::where('numdoc', $this->ruc)->first();

        if ($query) {
            $this->razon_social = $query->nomrazonsocial;
            $this->nombre_comercial = $query->nombrecomercial;
            $this->direccion = $query->address;
            //$this->departamento = $query->department->name;
            $this->departamento = optional($query->department)->name;
            $this->provincia = $query->province ? $query->province->name : null;
            $this->distrito = optional($query->district)->name;
        } else {


            $sunat = new \jossmp\sunat\ruc([
                'representantes_legales'     => false,
                'cantidad_trabajadores'     => false,
                'establecimientos'             => false,
                'deuda'                     => false,
            ]);

            $query = $sunat->consulta($this->ruc);

            if ($query->success) {

                $this->razon_social = $query->result->razon_social;
                $this->nombre_comercial = $query->result->nombre_comercial;
                $this->direccion = $query->result->direccion;
                $this->departamento = $query->result->departamento;
                $this->provincia = $query->result->provincia;
                $this->distrito = $query->result->distrito;
            }
        }
    }



    public function getTotales()
    {

        $this->mtoopergravadas = Temporal::where('company_id', $this->company_id)
            ->where('employee_id', auth()->user()->employee->id)->where('state', 0)
            ->where('tipafeigv', '10')
            ->sum('mtovalorventa'); //$mtovalorventa = $mtovalorunitario * $newQuantity;//es el subtotal sin inc IGV ejemplo 100 x 2 = 200


        $this->mtooperexoneradas = Temporal::where('company_id', $this->company_id)
            ->where('employee_id', auth()->user()->employee->id)->where('state', 0)
            ->where('tipafeigv', '20')
            ->sum('mtovalorventa'); // mtovalorventa  es precio sin igv X quantity

        $this->mtooperinafectas =  Temporal::where('company_id', $this->company_id)
            ->where('employee_id', auth()->user()->employee->id)->where('state', 0)
            ->where('tipafeigv', '30')
            ->sum('mtovalorventa'); //$mtovalorventa = $mtovalorunitario * $Quantity

        $this->mtooperexportacion =  Temporal::where('company_id', $this->company_id)
            ->where('employee_id', auth()->user()->employee->id)->where('state', 0)
            ->where('tipafeigv', '40')
            ->sum('mtovalorventa');

        $this->mtoopergratuitas =  Temporal::where('company_id', $this->company_id)
            ->where('employee_id', auth()->user()->employee->id)->where('state', 0)
            ->whereNotIn('tipafeigv', ['10', '20', '30', '40'])
            ->sum('mtovalorventa');

        $this->mtoigv =  Temporal::where('company_id', $this->company_id) //es la suma de todos los igv
            ->where('employee_id', auth()->user()->employee->id)->where('state', 0)
            ->whereIn('tipafeigv', ['10', '20', '30', '40'])
            ->sum('igv'); // es la suma de los IGV ejemplo 18 + 9 +180

        $this->mtoigvgratuitas =  Temporal::where('company_id', $this->company_id)
            ->where('employee_id', auth()->user()->employee->id)->where('state', 0)
            ->whereNotIn('tipafeigv', ['10', '20', '30', '40'])
            ->sum('igv');



        $this->icbper =  Temporal::where('company_id', $this->company_id)
            ->where('employee_id', auth()->user()->employee->id)->where('state', 0)
            ->where('esbolsa', 1)
            ->sum('icbper');

        $this->totalimpuestos = number_format($this->mtoigv + $this->icbper, 4); //formatea a 4 decimales si tiene 6 dcimales solo muestra 4 pero no redondea para redondear debemos usar round

        $this->valorventa =  Temporal::where('company_id', $this->company_id) //es el total sin inc igv ejemplo 100x2= 200 soles
            ->where('employee_id', auth()->user()->employee->id)->where('state', 0)
            ->whereIn('tipafeigv', ['10', '20', '30', '40'])
            ->sum('mtovalorventa'); //$mtovalorventa = $mtovalorunitario * $Quantity  ejemplo 100 x 2
        $this->valorventa = floatval($this->valorventa);
        $this->totalimpuestos = floatval($this->totalimpuestos);

        $this->subtotall = number_format($this->valorventa + $this->totalimpuestos, 4); // $this->valorventa es la suma de todos los  mtovalorventa de cada registro que esta en temporal

        //$this->mtoimpventa = floor($this->subtotall * 10) / 10;
        $this->mtoimpventa = floatval($this->subtotall);

        //$this->redondeo = $this->subtotall - $this->mtoimpventa;


    }

    public function getLegends()
    {
        $formatter = new NumeroALetras();

        $this->legends = [];

        $this->legends[] = [
            'code' => '1000',
            'value' => $formatter->toInvoice($this->subtotall, 4)
        ];

        /* if (collect($this->invoice['details'])->whereNotIn('tipAfeIgv', ['10', '20', '30', '40'])->count()) {
            $legends[] = [
                'code' => '1002',
                'value' => 'TRANSFERENCIA GRATUITA DE UN BIEN Y/O SERVICIO PRESTADO GRATUITAMENTE'
            ];
        } */

        if ($this->tipodeoperacion_codigo == '1001' &&  $this->subtotall > $this->company->detraccion) {
            $this->legends[] = [
                'code' => '2006',
                'value' => 'Operación sujeta a detracción'
            ];
        }

        // $this->invoice['legends'] = $legends;
        return $this->legends;
    }



    public function getTotalFromTemporals()
    {
        $formatter = new NumeroALetras();
        //cambiar por this->company_id
        $company_id = auth()->user()->employee->company->id;

        // Obtener el total de la tabla temporals para la empresa actual
        $this->total = Temporal::where('company_id', $company_id)
            ->where('employee_id', auth()->user()->employee->id)->where('state', 0)
            ->sum('subtotal');


        //$this->totalenletras = $formatter->toInvoice($this->subtotall, 4);
        //$this->totalenletras = $formatter->toInvoice($this->mtoimpventa, 2);
        $this->totalenletras = $formatter->toInvoice($this->total, 2);

        return $this->total; //esto controla la vista del carrito
        //return $this->totalenletras;
    }



    // actualizar cantidad item en carrito
    public function updateQty($id, $saleprice, $quantity = 1, $mtovalorunitario)
    {
        if ($quantity <= 0) {
            $this->removeItem($id);
        } else {
            $this->updateQuantity($id, $saleprice, $quantity, $mtovalorunitario);
        }
    }


    //pasaremos parametros desde la vista
    public function updateQuantity($id, $saleprice, $quantity, $mtovalorunitario)
    {
        $subtotal = $quantity * $saleprice;
        //$this->subtotall = $quantity * $saleprice;
        ////////////////////////////////////////
        //// debo actualizar en temporal  las variables que usan cantidades /////
        /////////////////////////////////////

        if ($saleprice > 0 and $quantity > 0) {
            $productelegido = Temporal::where('id', $id)->first();
            $productelegido->update([
                'quantity' => $quantity,
                'subtotal' => $subtotal,
                'mtobaseigv' => $quantity * $mtovalorunitario, //cantidad * precio sin igv
                'igv' => $subtotal - ($quantity * $mtovalorunitario), //es 118 -100= 18soles
                'icbper' => $quantity * $this->factoricbper,
                'totalimpuestos' => $quantity * $this->factoricbper + ($subtotal - ($quantity * $mtovalorunitario)),
                'mtovalorventa' => $mtovalorunitario * $quantity, //subtotal sin inc IGV ejemplo 100 x 2 = 200

            ]);
        }

        $this->total = $this->getTotalFromTemporals();
        //agregue esto para actualizar parametros
        $this->getTotales();
    }



    public function delete(Temporal $temporal) //elimina todo
    {
        //$this->authorize('update', $brand);

        $temporal->delete();
        $this->total = $this->getTotalFromTemporals();
        //agregue esto para actualizar parametros
        $this->getTotales();
        //debemos limiar el array invoive
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

    public function updatePrice($id, $saleprice, $quantity)
    {
        $subtotal = $quantity * $saleprice;
        $mtovalorunitario = $saleprice / (1 + ($this->igv * 0.01)); //actualizamos//precio de producto sin inc igv ejemplo 100
        $mtobaseigv = $quantity * $mtovalorunitario; //cantidad * precio sin igv
        $igv = $subtotal - ($quantity * $mtovalorunitario); //es 118 -100= 18soles
        $totalimpuestos = $quantity * $this->factoricbper + ($subtotal - ($quantity * $mtovalorunitario));
        $mtovalorventa = $mtovalorunitario * $quantity; //subtotal sin inc IGV ejemplo 100 x 2 = 200

        //se cambio el precio, cambiara precio sin igv, el igv y el subtotal
        if ($saleprice > 0 and $quantity > 0) {
            $productelegido = Temporal::where('id', $id)->first();
            $productelegido->update([
                'saleprice' => $saleprice,
                'subtotal' => $subtotal,
                'mtovalorunitario' => $mtovalorunitario,
                'mtobaseigv' => $mtobaseigv,
                'igv' => $igv,
                'totalimpuestos' => $totalimpuestos,
                'mtovalorventa' => $mtovalorventa, //subtotal sin inc IGV ejemplo 100 x 2 = 200
            ]);
        }


        $this->total = $this->getTotalFromTemporals();
        //agregue esto para actualizar parametros
        $this->getTotales();
    }

    public function limpiar()
    {
        Temporal::where('company_id', auth()->user()->employee->company->id)
            ->where('employee_id', auth()->user()->employee->id)
            ->where('state', 0) //no borramos el state 1 porque ya estan generados
            ->delete();
    }


    public function updatedCurrencyId($value)
    {
        // $this->moneda = Currency::where('id', $value);
        //$this->moneda = Currency::where('id', $value)->value('abbreviation');
        $currency = Currency::where('id', $value)->first();

        $this->moneda = $currency->abbreviation;
        //dd($this->moneda);
        $this->monedadescription = $currency->description;
    }

    public function updatedTipodeoperacionId($value)
    {
        // $this->moneda = Currency::where('id', $value);
        $this->tipodeoperacion_codigo = Tipodeoperacion::where('id', $value)->value('codigo');
    }


    public function updatedTipodocumentoId($value)
    {
        //si es RUC debe seleccionar factura en tipocomprobante osea tipocomprobante_id = 1
        //tipodocumento su id = 4  tipodocumento su codigo = 6
        if ($this->tipodocumento_id == 4) {
            $this->tipocomprobante_id = 1;
            $this->updatedTipocomprobanteId(1);
        } else {
            $this->tipocomprobante_id = 2;
            $this->updatedTipocomprobanteId(2);
        }

        $this->isDocumentTypeSelected = !empty($value);
        $this->ruc = "";
        $this->razon_social = "";
        $this->nombre_comercial = "";
        $this->direccion = "";
        $this->departamento = "";
        $this->provincia = "";
        $this->distrito = "";
    }

    //forma de pago
    public function updatedPaymenttypeId($value)
    {
        if ($value == 1) { // Contado
            $this->fechavencimiento = date('Y-m-d');
        } else {
            $this->fechavencimiento = null; // O cualquier otro valor por defecto
        }
    }




    //tipocomprobante_id
    //cuando seleccionas la lista comprobante
    public function updatedTipocomprobanteId($value)
    {
        $tipocomprobantes = auth()->user()->employee->local->tipocomprobantes;
        // Encuentra el tipo de comprobante seleccionado
        $selectedTipoComprobante = $tipocomprobantes->where('id', $value)->first();
        // Actualiza el valor de tipoDoc en tu array de invoice
        ////$this->tipodocumento_id = $selectedTipoComprobante->id; //aqui da el valor de tipocomprobante factura , boleta para enviara a sunat
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

        //$this->invoice['serie'] = $this->serie;
        //dd($this->invoice['serie']);

        $company_id = auth()->user()->employee->company->id;
        switch ($value) {
            case 1: //para factura

                $lastFactura = Factura::where('company_id', $company_id)
                    ->where('serie', $this->serie)
                    ->latest('numero')
                    ->first();

                if ($lastFactura) {
                    $this->numero = $lastFactura->numero + 1;
                } else {
                    //busco en la tabla companies configuracion dende se puso el numero
                    $lastFactura = Local_tipocomprobante::where('company_id', $company_id)
                        ->where('serie', $this->serie)
                        ->where('local_id', auth()->user()->employee->local->id)
                        ->where('tipocomprobante_id', 1)
                        ->first();
                    if ($lastFactura)
                        $this->numero = $lastFactura->inicio;
                }

                break;



            case 2:
                $lastBoleta = Boleta::where('company_id', $company_id)
                    ->where('serie', $this->serie)
                    ->latest('numero')
                    ->first();
                //dd($lastBoleta);
                if ($lastBoleta) {
                    $this->numero = $lastBoleta->numero + 1;
                } else {
                    //busco en la tabla companies configuracion dende se puso el numero
                    $lastBoleta = Local_tipocomprobante::where('company_id', $company_id)
                        ->where('serie', $this->serie)
                        ->where('local_id', auth()->user()->employee->local->id)
                        ->where('tipocomprobante_id', 2)
                        ->first();
                    if ($lastBoleta)
                        $this->numero = $lastBoleta->inicio;
                }

                //$this->numero = $lastBoleta ? $lastBoleta->numero + 1 : 1;
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
        //'tipodocumento_id' => 'required',
        //'customer_id' => 'required',
        'tipocomprobante_id' => 'required',
        'paymenttype_id' => 'required',
        'fechaemision' => 'required|date',
        //'fechavencimiento' => 'required|date|before_or_equal:fechaemision',
        'fechavencimiento' => 'required|date|after_or_equal:fechaemision',
        'currency_id' => 'required',
        'serie' => 'required',
        'numero' => 'required',
    ];


    /*    public function removeAccents($text)
    {
        $text = htmlentities($text, ENT_NOQUOTES, 'UTF-8');
        $text = preg_replace('/&([a-zA-Z])(acute|grave|circ|tilde|uml);/', '$1', $text);
        return $text;
    } */







    //guardamos el comprobante
    public function save()
    {
        //validaremos y guardaremos al cliente
        //dd($this->subtotall <= $this->company->detraccion);
        // Realiza la validación aquí
        if ($this->tipodeoperacion_codigo == '1001') { //venta con igv es el 1001
            if ($this->subtotall <= $this->company->detraccion) {
                //throw new \Exception("El subtotal debe ser mayor que la detracción de la empresa.");
                $this->emit('alert', 'El total debe ser mayor que la detracción');
                return;
            }
        }


        if ($this->tipodocumento_id == "") {
            $this->emit('alert', 'Escoge el DNI, RUC, CE ...');
            return;
        }

        //el cliente esta en la tabla customer
        //buscamos el cliente y el tipo documento ruc, dni, carnet de extranjeria, etc
        ////$customer = Customer::find($this->customer_id);//se va crear el cliente
        $tipodocumento = Tipodocumento::find($this->tipodocumento_id); //ruc , dni

        $numecar = Str::length($this->ruc); //calcula la longitud de ruc, dni, ce, etc..

        //si loescogido es 1(dni), 4, 6(ruc)
        switch ($tipodocumento->codigo) {
            case '1':
                //indicar 8 digitos dni
                if ($numecar != 8) {
                    $this->emit('alert', 'el DNI Debe tener 8 digitos');
                    return;
                }
                break;
            case '4':
                //carnet de extranjeria

                break;
            case '6':
                //ruc
                if ($numecar != 11) {
                    $this->emit('alert', 'el RUC Debe tener 11 digitos');
                    return;
                }
                break;
            default:

                break;
        }

        //dd($tipodocumento->abbreviation);
        //dd($this->invoice['company']['address']['codLocal']);
        // Validación de que la fecha de vencimiento sea mayor o igual a la fecha de emisión
        $this->local_id = auth()->user()->employee->local->id;
        //factura. boleta
        $this->local_tipocomprobante_id = Local_tipocomprobante::where('local_id', $this->local_id)->where('tipocomprobante_id', $this->tipocomprobante_id)->value('id');

        $this->serienumero = $this->serie . "-" . $this->numero;
        //dd($this->serienumero);
        //buscamos en la tabla departamento
        if ($this->departamento) {
            $departamento = ucwords(strtolower($this->departamento)); //ejemplo Madre De Dios
            $departamentoEncontrado = Department::where('name', $departamento)->orWhere('name2', $departamento)->first();
            $department_id = $departamentoEncontrado->id;
        } else {
            $department_id = NULL;
        }

        //buscamos en la tabla provincia
        if ($this->provincia) {
            $provincia = ucwords(strtolower($this->provincia));
            //dd($provincia);
            //dd($departamentoEncontrado->provinces);
            //$provinciaEncontrado = Province::where('name', $provincia)->first();
            //$provinciaEncontrado  = $departamentoEncontrado->provinces->where('name', $provincia)->first();

            $provinciaEncontrado = $departamentoEncontrado->provinces()
            ->where(function ($query) use ($provincia) {
                $query->where('name', $provincia)
                    ->orWhere('name2', $provincia);
            })
            ->first();

            //dd($provinciaEncontrado );
            $province_id = $provinciaEncontrado->id;
        } else {
            $province_id = NULL;
        }




        //buscamos en la tabla distrito
        if ($this->distrito) {
            $distrito = ucwords(strtolower($this->distrito));

            //$distrito = htmlentities($distrito, ENT_NOQUOTES, 'UTF-8');
            //$distrito = preg_replace('/&([a-zA-Z])(acute|grave|circ|tilde|uml);/', '$1', $distrito);


            // $distrito = $this->removeAccents($distrito);
            //$distritoEncontrado = District::where('name', $distrito)->first();
            //$distritoEncontrado  = $provinciaEncontrado->districts->where('name', $distrito)->orwhere('name2', $distrito)->first();

            // Buscar el distrito en la base de datos
            $distritoEncontrado = $provinciaEncontrado->districts()
                ->where(function ($query) use ($distrito) {
                    $query->where('name', $distrito)
                        ->orWhere('name2', $distrito);
                })
                ->first();

            if ($distritoEncontrado) {
                $district_id = $distritoEncontrado->id;
            } else {
                $district_id = NULL;
            }
        } else {
            $district_id = NULL;
        }

        //guardamos al cliente en la tabla customers
        //a direccion le damos null si esta vacio
        $direccion = !empty($this->direccion) ? $this->direccion : null;

        $customer = Customer::where('numdoc', $this->ruc)->where('company_id', auth()->user()->employee->company->id)->first();
        if (!$customer) {
            $customer = Customer::create([
                'tipodocumento_id' => $tipodocumento->id,
                'numdoc' => $this->ruc,
                'nomrazonsocial' => $this->razon_social,
                'nombrecomercial' => $this->nombre_comercial,
                'address' => $direccion,
                'department_id' => $department_id,
                'province_id' => $province_id,
                'district_id' => $district_id,
                'company_id' => auth()->user()->employee->company->id,
            ]);
        };

        // dd($customer);

        // Los valores que deseas insertar o actualizar
        /*  $valores = [
            'tipodocumento_id' => $tipodocumento->id,
            'nomrazonsocial' => $this->razon_social,
            'nombrecomercial' => $this->nombre_comercial,
            'address' => $this->direccion,
            'department_id' => $departamentoEncontrado->id,
            'province_id' => $provinciaEncontrado->id,
            'district_id' => $distritoEncontrado->id,
        ]; */

        // La condición para buscar el registro existente basado en el RUC
        /* $condicion = ['numdoc' => $this->ruc]; */


        // Llamar a updateOrCreate
        /* $customer = Customer::updateOrCreate($condicion, $valores); */

        $this->validate();

        //guadamos la tabla comprobantes
        $comprobante = Comprobante::create([
            //'customer_id' => $this->customer_id,
            'customer_id' => $customer->id,
            'local_id' => $this->local_id,
            'tipocomprobante_id' => $this->tipocomprobante_id, //factura boleta
            'local_tipocomprobante_id' => $this->local_tipocomprobante_id,
            'company_id' => auth()->user()->employee->company->id, //encontramos la company actual osea la compania del usuario logueado
            'employee_id' => auth()->user()->employee->id,
            //guardaremos campos para facturacion electronica
            'tipodeoperacion_id' => $this->tipodeoperacion_id, //venta interna en este caso ponemos 0101, pero em la tabla tiene id = 1
            'tipodocumento_id' => $this->tipodocumento_id, //ruc, dni
            'fechaemision' =>  $this->fechaemision,
            'fechavencimiento' =>  $this->fechavencimiento,
            'paymenttype_id' => $this->paymenttype_id, //contado, credito
            'currency_id' => $this->currency_id, //PEN, USD
            'mtoopergravadas' => $this->mtoopergravadas,
            'mtooperexoneradas' => $this->mtooperexoneradas,
            'mtooperinafectas' => $this->mtooperinafectas,
            'mtooperexportacion' => $this->mtooperexportacion,
            'mtoopergratuitas' => $this->mtoopergratuitas,
            'mtoigv' => $this->mtoigv,
            'mtoigvgratuitas' => $this->mtoigvgratuitas,
            'icbper' => $this->icbper,
            'totalimpuestos' => $this->totalimpuestos,
            'valorventa' => $this->valorventa,
            'subtotal' => $this->subtotall,
            'mtoimpventa' => $this->mtoimpventa,
            'redondeo' => $this->redondeo,
            'legends' => json_encode($this->getLegends()),
            'serienumero' => $this->serienumero,
            //'legends' => json_encode($this->legends),
            //anticipos
            //detracciones
            'nota' => $this->nota,

        ]);

        //guardamos de acuerdo al comprobante escogido, boleta, factura
        //boletas y facturas tienen una relacion de uno a uno con comprobantes
        switch ($this->tipocomprobante_id) {
            case '1':
                //guardamos en la tabla factura
                //se guardara en la variable $boleta, indepenientemente si es factura,nc,guia, etc
                //$boleta tiene la ultima factura creada
                $boleta = Factura::create([
                    'serie' => $this->serie,
                    'numero' => $this->numero,
                    'serienumero' => $this->serienumero,
                    'fechaemision' =>  $this->fechaemision,
                    'fechavencimiento' => $this->fechavencimiento,
                    'total' => $this->total,
                    'comprobante_id' => $comprobante->id,
                    'company_id' => auth()->user()->employee->company->id,
                    'paymenttype_id' => $this->paymenttype_id,
                    'currency_id' => $this->currency_id,
                    'tipodecambio_id' => 1, //1 es un codigo de la tabla tipo de cambios es el id
                    //guardaremos campos para facturacion electronica
                ]);

                break;

            case '2':
                //guardamos en la tabla boletas
                //se guardara en la variable $boleta indepenientemente si es factura, nc,guia, etc
                //$boleta tiene la ultima boleta creada
                $boleta = Boleta::create([
                    'serie' => $this->serie,
                    'local_id' => $this->local_id,
                    'numero' => $this->numero,
                    'serienumero' => $this->serienumero,
                    'fechaemision' =>  $this->fechaemision,
                    'fechavencimiento' => $this->fechavencimiento,
                    'total' => $this->total,
                    'comprobante_id' => $comprobante->id,
                    'company_id' => auth()->user()->employee->company->id,
                    'paymenttype_id' => $this->paymenttype_id,
                    'currency_id' => $this->currency_id,
                    'tipodecambio_id' => 1, //1 es un codigo de la tabla tipo de cambios es el id
                    //guardaremos campos para facturacion electronica
                ]);
                break;
            case '6':
                //ruc
                if ($numecar != 11) {
                    $this->emit('alert', 'el RUC Debe tener 11 digitos');
                    return;
                }
                break;
            default:

                break;
        }

        //guadamos la tabla comprobante_product
        //Temporal fue alimentado al adicionar producto y se pone state=0
        //$temporals tiene lo escogido para la venta en el carrito actual
        $temporals = Temporal::where('company_id', auth()->user()->employee->company->id)
            ->where('employee_id', auth()->user()->employee->id)
            ->where('state', 0)->get(); //state 0 tiene los temporales actuales osea se muestra en el carrito o post, state 1, no se muestra en el carrito o pos, ya esta grabado en la bd pero no enviado a sunat

        // dd($temporals);

        foreach ($temporals as $temporal) {
            //si el producto es bolsa agregar icbper de lo contrario no///////////////////////////////
            //$this->invoice['details'][] = $this->item;
            Comprobante_Product::create([
                'cant' => $temporal->quantity,
                'price' => $temporal->saleprice,
                'subtotal' => $temporal->subtotal,
                'product_id' => $temporal->product_id,
                'comprobante_id' => $comprobante->id,
                'company_id' => $this->company_id,
                'codigobarras' => $temporal->codigobarras, //codigo del producto que necesita la facturacion electronica
                'mtobaseigv' => $temporal->mtobaseigv,
                'igv' => $temporal->igv,
                'icbper' => $temporal->icbper,
                'totalimpuestos' => $temporal->totalimpuestos,
                'mtovalorventa' => $temporal->mtovalorventa,
            ]);
        }

        //$this->getTotales();
        //$this->getLegends();



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
        //$boleta tiene el ultimo registro creado de factura o boleta
        //$temporals tiene lo seleccionado en el carrito pero con state=0
        //$comprobante  es el ultimo comprobante creado
        //$this->company la compania logueada
        $sunat = new SunatService($comprobante, $this->company, $temporals, $boleta, null);

        $sunat->getSee();
        $sunat->setInvoice();

        switch ($this->sending_method) {
            case '1': //cuando manda el cdr, generaxml y guarda el comprobante
                $sunat->send(); //send es el metodo de greenter
                $temporals->each->delete(); //eliminamos temporal porque ya se envio
                $this->emit('alert', 'El comprobante se creo correctamente y se envio a sunat');
                break;

            case '2': //cuando genera el xml y guarda el comprobante
                //genrando el xml
                $sunat->generateXml(); //genera el xml
                //poniendo el state a 1 para posteriormente enviar a sunat
                foreach ($temporals as $temporal) {
                    $temporal->state = 1; //guarda en el temporal para indicar que se guardo y genero xlm pero no se envio a sunat
                    $temporal->comprobante_id = $comprobante->id; //guarda en el temporal para saber de que empresa es
                    $temporal->save();
                }

                $this->emit('alert', 'El comprobante se creo y firmo correctamente, pero no se envio a SUNAT');

                break;

            case '3': //cuando guarda el comprobante
                //poniendo el state a 1 para posteriormente enviar a sunat
                foreach ($temporals as $temporal) {
                    $temporal->state = 1;
                    $temporal->comprobante_id = $comprobante->id;
                    $temporal->save();
                }
                //La factura se guardo pero no se envio a sunat
                $this->emit('alert', 'El comprobante se creo, pero no se firmo ni envio a SUNAT');

                break;
        }


        $sunat->generatePdfReport();


        /*  $sunat->send();
        $sunat->generatePdfReport(); */

        //$temporals->each->delete();///luego activarlo

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
        //$this->mtoimpventa

        $company_id = auth()->user()->employee->company->id;


        $cart = Temporal::where('company_id', $company_id)
            ->where('employee_id', auth()->user()->employee->id)->where('state', 0)->get();

        //dd($cart);

        $customers = Customer::all();
        $currencies = Currency::all();
        $tipodocumentos = Tipodocumento::all();
        $tipodeoperacions = Tipodeoperacion::all();


        $tipocomprobantes = auth()->user()->employee->local->tipocomprobantes;
        //dd($tipocomprobantes);
        $this->getTotales();
        $this->total = $this->getTotalFromTemporals();


        return view('livewire.admin.comprobante-create', compact('customers', 'currencies', 'tipocomprobantes', 'cart', 'tipodocumentos', 'tipodeoperacions'));
    }
}
