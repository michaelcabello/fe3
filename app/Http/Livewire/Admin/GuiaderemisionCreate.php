<?php

namespace App\Http\Livewire\Admin;

use App\Models\Um;
use Carbon\Carbon;
use App\Models\Guia;
use App\Models\Local;
use Livewire\Component;
use App\Models\District;
use App\Models\Province;
use App\Models\Vehiculo;
use App\Models\Conductor;
use App\Models\Department;
use App\Models\Temporalgr;
use App\Models\Comprobante;
use App\Models\Tipodocumento;
use App\Models\Transportista;
use App\Models\Motivotraslado;
use App\Models\Puntodepartida;
use App\Services\SunatService;
use App\Models\Comprobante_Product;
use App\Models\Local_tipocomprobante;


class GuiaderemisionCreate extends Component
{

    public $company, $comprobante;
    public $company_id;
    public $tipocomprobante_id = 7; //si es NC Boleta, NC Factura, si es guia de remision = 7
    public $tipocomprobante_namecorto;
    public $serie;
    public $numero;

    public $tipodocumento_id;
    public $serienumero, $local_id, $ruc, $customer_id; //$departamento = "LIMA", $provincia = "LIMA", $distrito = "LIMA";
    public $local_tipocomprobante_id;
    public $fechaemision, $motivotraslado_id = "", $modalidaddetraslado = "", $fechadetraslado;
    public $pesototal, $um_id = "", $conductor_id = "", $vehiculo_id = "", $puntodepartida_id = 0;
    public $transportista_id="", $ubigeollegada;
    public $department_id = "", $province_id = "", $district_id = "";
    public $departments, $provinces = [], $districts = [], $direccionllegada;
    public $datosEliminados = false;
    public $details = [];
/*     public $item = [
        'cant' => '',
        'product_id' => '',
        'comprobante_id' => '',
        'company_id' => '',
        'codigobarras' => '',
    ]; */

    public $sending_method;

    protected $listeners = ['delete', 'limpiar'];

    public function mount(Comprobante $id)
    {
        $this->comprobante = $id; //$this->comprobante es el comprobante al cual se esta haciendo guia de remisión
        if ($this->comprobante->tipocomprobante_id != 1 && $this->comprobante->tipocomprobante_id != 2) {
            abort(403, 'Sólo se hace Guias de Facturas y Boletas.');
            return;
        }

        $this->departments = Department::all(); //lista todo los departamentos
        $this->company = auth()->user()->employee->company;
        $this->company_id = auth()->user()->employee->company->id; //compañia logueaada

        $this->fechaemision = Carbon::now()->format('Y-m-d');
        //$this->fechadetraslado = Carbon::now()->format('Y-m-d');

        $this->ruc = $this->comprobante->numdoc; //numero de ruc o dni del documento que se realizara guia osea del cliente o destinatario
        $this->customer_id = $this->comprobante->customer_id; //id del cliente

        $this->tipodocumento_id = $this->comprobante->tipodocumento_id; //para ver si el dni, ruc, ce

        $local = auth()->user()->employee->local;


        $this->serie = $local->tipocomprobantes
            ->where('id', $this->tipocomprobante_id)
            ->first()
            ->pivot
            ->serie ?? "null";

        $lastGuia = Guia::where('company_id', $this->company_id)
            ->where('serie', $this->serie)
            ->latest('numero')
            ->first();

        if ($lastGuia) {
            $this->numero = $lastGuia->numero + 1;
        } else {
            //busco en la tabla companies configuracion dende se puso el numero
            $lastGuia = Local_tipocomprobante::where('company_id', $this->company_id)
                ->where('serie', $this->serie)
                ->where('local_id', auth()->user()->employee->local->id)
                //->where('tipocomprobante_id', 3)
                ->first();
            if ($lastGuia)
                $this->numero = $lastGuia->inicio;
        }

        //$this->initialize($id);
        if (!$this->datosEliminados) {
            $this->datosEliminados = true;
            $this->company_id = auth()->user()->employee->company->id;
            $temporalgr = Temporalgr::where('company_id', $this->company_id)
                ->where('employee_id', auth()->user()->employee->id)->get();

            /* Temporalnc::where('company_id', $this->company_id)
                ->where('employee_id', auth()->user()->employee->id)->delete(); */
            if ($temporalgr->isNotEmpty()) {
                $temporalgr->each->delete();
            }
            //obtenemos detalle de comprobante de una compania,falta restringir por local y usuario
            $detalle = Comprobante_Product::where('comprobante_id', $this->comprobante->id)
                ->where('company_id', $this->company_id)->get(); //falta restringir para que solo ,uestre lo que le corresponde osea no de otro local ni de otra empresa
            //Guardamos
            $this->llenartemporal($detalle);
        }
    }


    public function llenartemporal($detalle)
    {
        foreach ($detalle as $item) {
            Temporalgr::create([
                //'serienumero' => $item->comprobante->serienumero,
                'quantity' => $item->cant,
                //'saleprice' => $item->price,
                //'subtotal' => $item->subtotal,
                'product_id' => $item->product_id,

                'company_id' => $item->company_id,
                'employee_id' => auth()->user()->employee->id,
                'codigobarras' => $item->codigobarras, //codigo del producto que necesita la facturacion electronica
                //'igv' => $item->igv,
                //'icbper' => $item->icbper,
                //'totalimpuestos' => $item->totalimpuestos,
                //'mtovalorunitario' => floatval($mtovalorunitario),
                //'mtovalorventa' => floatval($item->mtovalorventa),
                //'mtobaseigv' => floatval($item->mtobaseigv),
                'name' => $item->product->name,
                'um' => $item->product->um->abbreviation,
                //'tipafeigv' => $item->product->tipoafectacion->codigo,
                //'porcentajeigv' => $this->igv,  //igv lo tenemos en el mount es 18%
                //'factoricbper' => $this->factoricbper,  //factoricbper lo tenemos en el mount es 0.2
            ]);
        }
    }


    public function updatedDepartmentId($value)
    {
        $this->provinces = Province::where('department_id', $value)->get();
        $this->reset(['province_id', 'district_id']);
    }



    public function updatedProvinceId($value)
    {
        $this->districts = District::where('province_id', $value)->get();
        $this->reset('district_id');
    }


    //guardamos el comprobante
    public function save()
    {
        $this->ubigeollegada = $this->district_id;
        $this->local_id = auth()->user()->employee->local->id;
        //factura. boleta
        $this->local_tipocomprobante_id = Local_tipocomprobante::where('local_id', $this->local_id)->where('tipocomprobante_id', $this->tipocomprobante_id)->value('id');

        $this->serienumero = $this->serie . "-" . $this->numero;
        //dd($this->local_tipocomprobante_id);
        //Los datos del cliente yaestan guardados
        // $this->validate();
        //guadamos la tabla comprobantes se crea el comprobante de la GUIA, guardamos esto para listar en la tabla comprobantes
        //no crearemos comprobante, la guia era independiente y no se listara en la lista de comprobanyes de venta
        //$comprobante = Comprobante::create([
            //'customer_id' => $this->customer_id,
            //'local_id' => $this->local_id,
            //'tipocomprobante_id' => $this->tipocomprobante_id, //NC NOTa de credito
            //'local_tipocomprobante_id' => $this->local_tipocomprobante_id, ///////////////////averiguar que es
            //'company_id' => auth()->user()->employee->company->id, //encontramos la company actual osea la compania del usuario logueado
            //'employee_id' => auth()->user()->employee->id,
            //'tipodocumento_id' => $this->tipodocumento_id, //ruc, dni el $this->tipodocumento_id es 4 pero su codigo es 6
            //'fechaemision' =>  $this->fechaemision,
            //'serienumero' => $this->serienumero,

        //]);

        //guardamos en $temporals todo lo que se va gravar en la tabla comprobante_product
        $temporals = Temporalgr::where('company_id', auth()->user()->employee->company->id)
            ->where('employee_id', auth()->user()->employee->id)->get();


        $temporalsData = $temporals->map(function ($temporal) {
            return [
                'cant' => $temporal->quantity,
                'product_id' => $temporal->product_id,
                'company_id' => $this->company_id,
                'codigobarras' => $temporal->codigobarras,
            ];
        });


        //dd($temporals);
        //agregamos el aditem

        /* foreach ($temporals as $temporal) {

                ([
                'cant' => $temporal->quantity,
                'product_id' => $temporal->product_id,
                'comprobante_id' => $comprobante->id,
                'company_id' => $this->company_id,
                'codigobarras' => $temporal->codigobarras, //codigo del producto que necesita la facturacion electronica
            ]);
        } */


        $boleta = Guia::create([
            'details' => $temporalsData->toJson(),
            'serie' => $this->serie,
            'numero' => $this->numero,
            'serienumero' => $this->serienumero,
            'fechaemision' =>  $this->fechaemision,
            'comprobante_id' => $this->comprobante->id, //la guia tiene el id del comprobante, no del comprobante creado, sino del comprobante relacionado(factura o boleta) al que se hizo guia
            'company_id' =>  $this->company_id,
            'customer_id' => $this->customer_id,
            'motivotraslado_id' => $this->motivotraslado_id,
            'modalidaddetraslado' => $this->modalidaddetraslado,
            'fechadetraslado' => $this->fechadetraslado,
            'pesototal' => $this->pesototal,
            'um_id' => $this->um_id,
            /*  'numpaquetes' => $this->numpaquetes,
            'descripcion' => $this->descripcion,
            'observacion' => $this->observacion, */
            'transportista_id' => $this->transportista_id,
            'direccionllegada' => $this->direccionllegada,
            'department_id' => $this->department_id,
            'province_id' => $this->province_id,
            'district_id' => $this->district_id,
            'ubigeollegada' => $this->ubigeollegada,
            'puntodepartida_id' => $this->puntodepartida_id,

            /*  'paymenttype_id' => $this->paymenttype_id,
            'currency_id' => $this->currency_id,
            'tipodecambio_id' => $this->tipodecambio_id, */

            /* 'send_xml' => $this->send_xml,
            'sunat_success' => $this->sunat_success,
            'sunat_error' => $this->sunat_error,
            'hash' => $this->hash,
            'xml_path' => $this->xml_path,
            'pdf_path' => $this->pdf_path,
            'sunat_cdr_path' => $this->sunat_cdr_path,
            'cdr_code' => $this->cdr_code,
            'cdr_notes' => $this->cdr_notes,
            'cdr_description' => $this->cdr_description, */
        ]);

        if($this->modalidaddetraslado=='02'){
            $boleta->vehiculos()->attach($this->vehiculo_id);
            $boleta->conductors()->attach($this->conductor_id);
        }

        $sunat = new SunatService($comprobante=null, $this->company, $temporals, $boleta);

        $sunat->getSeeApi($this->company);
        $sunat->setDespatch();
        $sunat->sendDespatch();
        $sunat->generatePdfReport();


    }






    public function render()
    {

        $motivotraslados = Motivotraslado::all(); //restringir para que muestre solo de su compañia
        $tipodocumentos = Tipodocumento::all();
        $ums = Um::all();
        $transportistas = Transportista::all();
        $conductors = Conductor::all();
        $vehiculos = Vehiculo::all();
        $puntodepartidas = Puntodepartida::all();
        $cart = Temporalgr::all();

        return view('livewire.admin.guiaderemision-create', compact('motivotraslados', 'tipodocumentos', 'ums', 'transportistas', 'conductors', 'vehiculos', 'puntodepartidas', 'cart'));
    }
}
