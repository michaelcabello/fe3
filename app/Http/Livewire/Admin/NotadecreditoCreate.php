<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Impuesto;
use App\Models\Temporalnc;
use App\Models\Comprobante;
use App\Models\Comprobante_Product;
use Luecano\NumeroALetras\NumeroALetras;


class NotadecreditoCreate extends Component
{

    public $comprobante, $detalle, $igv, $factoricbper;

    public $mtoopergravadas, $mtooperexoneradas, $mtooperinafectas, $mtooperexportacion, $mtoopergratuitas, $mtoigv, $mtoigvgratuitas, $icbper, $totalimpuestos;
    public $valorventa, $subtotall, $mtoimpventa, $redondeo, $legends;
    public $totalenletras;

    public $company_id;
    public $moneda;





    public function mount(Comprobante $id)
    {
        $this->company_id = auth()->user()->employee->company->id; //compañia logueaada
        $this->moneda = auth()->user()->employee->company->currency->abbreviation ?? 'Sol';
        $this->igv = Impuesto::where('siglas', 'IGV')->value('valor'); //es el 18%
        $this->factoricbper = Impuesto::where('siglas', 'ICBPER')->value('valor'); //es 0.2
        $this->comprobante = $id;
        //seleccionamos
        $detalle = Comprobante_Product::where('comprobante_id', $this->comprobante->id)->get(); //falta restringir para que solo ,uestre lo que le corresponde osea no de otro local ni de otra empresa
        //Guardamos
        $this->llenartemporal($detalle);


    }

    public function llenartemporal($detalle)
    {
        foreach ($detalle as $item)
        {
            Temporalnc::create([
                'quantity' => $item->cant,
                'saleprice' => $item->price,
                'subtotal' => $item->subtotal,
                'product_id' => $item->product_id,
                'comprobante_id' => $item->comprobante_id,
                'company_id' => $item->company_id,
                'employee_id' => auth()->user()->employee->id,
                'codigobarras' => $item->codigobarras, //codigo del producto que necesita la facturacion electronica
                'mtobaseigv' => $item->mtobaseigv,
                'igv' => $item->igv,
                'icbper' => $item->icbper,
                'totalimpuestos' => $item->totalimpuestos,
                'mtovalorventa' => $item->mtovalorventa,
                'name' => $item->product->name,
                'um' => $item->product->um->abbreviation,
                'tipafeigv' => $item->product->tipoafectacion->codigo,
                'porcentajeigv' => $this->igv,  //igv lo tenemos en el mount es 18%
                'factoricbper' => $this->factoricbper,  //factoricbper lo tenemos en el mount es 0.2

            ]);

        }

    }


    public function getTotales()
    {

        $this->mtoopergravadas = Temporalnc::where('company_id', $this->company_id)
            ->where('employee_id', auth()->user()->employee->id)
            ->where('tipafeigv', '10')
            ->sum('mtovalorventa'); //$mtovalorventa = $mtovalorunitario * $newQuantity;//es el subtotal sin inc IGV ejemplo 100 x 2 = 200


        $this->mtooperexoneradas = Temporalnc::where('company_id', $this->company_id)
            ->where('employee_id', auth()->user()->employee->id)
            ->where('tipafeigv', '20')
            ->sum('mtovalorventa'); // mtovalorventa  es precio sin igv X quantity

        $this->mtooperinafectas =  Temporalnc::where('company_id', $this->company_id)
            ->where('employee_id', auth()->user()->employee->id)
            ->where('tipafeigv', '30')
            ->sum('mtovalorventa'); //$mtovalorventa = $mtovalorunitario * $Quantity

        $this->mtooperexportacion =  Temporalnc::where('company_id', $this->company_id)
            ->where('employee_id', auth()->user()->employee->id)
            ->where('tipafeigv', '40')
            ->sum('mtovalorventa');

        $this->mtoopergratuitas =  Temporalnc::where('company_id', $this->company_id)
            ->where('employee_id', auth()->user()->employee->id)
            ->whereNotIn('tipafeigv', ['10', '20', '30', '40'])
            ->sum('mtovalorventa');

        $this->mtoigv =  Temporalnc::where('company_id', $this->company_id) //es la suma de todos los igv
            ->where('employee_id', auth()->user()->employee->id)
            ->whereIn('tipafeigv', ['10', '20', '30', '40'])
            ->sum('igv'); // es la suma de los IGV ejemplo 18 + 9 +180

        $this->mtoigvgratuitas =  Temporalnc::where('company_id', $this->company_id)
            ->where('employee_id', auth()->user()->employee->id)
            ->whereNotIn('tipafeigv', ['10', '20', '30', '40'])
            ->sum('igv');



        $this->icbper =  Temporalnc::where('company_id', $this->company_id)
            ->where('employee_id', auth()->user()->employee->id)
            ->where('esbolsa', 1)
            ->sum('icbper');

        $this->totalimpuestos = number_format($this->mtoigv + $this->icbper, 4); //formatea a 4 decimales si tiene 6 dcimales solo muestra 4 pero no redondea para redondear debemos usar round

        $this->valorventa =  Temporalnc::where('company_id', $this->company_id) //es el total sin inc igv ejemplo 100x2= 200 soles
            ->where('employee_id', auth()->user()->employee->id)
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

       /*  if ($this->tipodeoperacion_codigo == '1001' &&  $this->subtotall > $this->company->detraccion) {
            $this->legends[] = [
                'code' => '2006',
                'value' => 'Operación sujeta a detracción'
            ];
        } */

        // $this->invoice['legends'] = $legends;
        return $this->legends;
    }



    public function render()
    {
        $this->getTotales();
        $this->getLegends();

        $cart = Temporalnc::all();
        return view('livewire.admin.notadecredito-create', compact('cart'));
    }
}
