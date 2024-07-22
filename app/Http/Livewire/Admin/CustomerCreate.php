<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Customer;
use Illuminate\Support\Str;
use App\Models\Tipodocumento;

class CustomerCreate extends Component
{

public $tipodocumento_id;
public $ruc, $razon_social, $nombre_comercial, $direccion="";
public $departamento, $provincia, $distrito;
public $tipocomprobante_id;
public $isDocumentTypeSelected = false;
public $company, $company_id;


public function mount()
{
    $this->company = auth()->user()->employee->company;
    $this->company_id = auth()->user()->employee->company->id; //compañia logueaada
}

public function updatedTipodocumentoId($value)
{
    //si es RUC debe seleccionar factura en tipocomprobante osea tipocomprobante_id = 1
    //tipodocumento su id = 4  tipodocumento su codigo = 6
    if($this->tipodocumento_id == 4){
        $this->tipocomprobante_id = 1;
        $this->updatedTipocomprobanteId(1);
    }else{
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
            $this->direccion = $query->address==null ? 'nada' : $query->address ;
            $this->departamento = $query->department->name;
            $this->provincia = $query->province->name;
            $this->distrito = $query->district->name;
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



    public function render()
    {
        $tipodocumentos = Tipodocumento::all();

        return view('livewire.admin.customer-create', compact('tipodocumentos'));
    }
}
