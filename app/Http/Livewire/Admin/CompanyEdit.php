<?php

namespace App\Http\Livewire\Admin;

use App\Models\Company;
use Livewire\Component;
use App\Models\Currency;
use App\Models\District;
use App\Models\Province;
use App\Models\Department;
use Livewire\WithFileUploads;

class CompanyEdit extends Component
{

    use WithFileUploads;

    public $company;//guardaremos el company logueado
    public $companysolicitado;//para controlar que modifique su empresa y no de otras
    public $ruc, $razonsocial, $direccion;
    public $departments, $provinces = [], $districts = [], $currencies;
    public $department_id = "", $province_id = "", $district_id = "";
    public $nombrecomercial;
    public $soluser, $solpass, $cliente_id, $cliente_secret;
    public $logo, $logoback;
    public $certificate_path, $certificate_pathback;
    public $fechainiciocertificado;
    public $fechafincertificado;
    public $currency_id = "";
    public $production = "";

    protected $listeners = ['fechaInicioSeleccionada'];

    public function mount($id)
    {
        $this->company = auth()->user()->employee->company;
        //$this->company_id = auth()->user()->employee->company->id; //compañia logueaada
        if($id != $this->company->id)
        {
            return;
        }


        $this->ruc = $this->company->ruc;
        $this->razonsocial = $this->company->razonsocial;
        $this->direccion = $this->company->direccion;
        $this->soluser = $this->company->soluser;
        $this->solpass = $this->company->solpass;
        $this->cliente_id = $this->company->cliente_id;
        $this->cliente_secret = $this->company->cliente_secret;
        $this->certificate_path = $this->company->certificate_path;
        $this->certificate_pathback = $this->company->certificate_path;
        $this->logo = $this->company->logo;
        $this->logoback = $this->company->logo;

        //$this->department_id = $this->company->department_id;
        //$this->department_id = str_pad($this->company->department_id, 2, '0', STR_PAD_LEFT);
        //$this->department_id = sprintf("%02d", $this->company->department_id);
        $this->department_id = str_pad((string)$this->company->department_id, 2, '0', STR_PAD_LEFT);
        $this->province_id = str_pad((string)$this->company->province_id, 4, '0', STR_PAD_LEFT); //$this->company->province_id;
        $this->district_id = str_pad((string)$this->company->district_id, 2, '0', STR_PAD_LEFT); //$this->company->district_id;

        $this->departments = Department::all(); //lista todo los departamentos
        $this->provinces = Province::where('department_id', $this->department_id)->get();
        $this->districts = District::where('province_id', $this->province_id)->get();

        $this->currency_id = $this->company->currency_id;
        $this->currencies = Currency::all(); //lista Monedas

        $this->production = $this->company->production;



    }




    public function fechaInicioSeleccionada($fechaInicio)
    {
        $this->fechainiciocertificado = $fechaInicio;
        $this->fechafincertificado = date('Y-m-d', strtotime($fechaInicio . ' +1 year'));
    }



    public function updatedDepartmentId($value)
    {
        // Asegurar que $value sea una cadena con ceros a la izquierda
        $this->department_id = str_pad((string)$value, 2, '0', STR_PAD_LEFT);
        $this->provinces = Province::where('department_id', $this->department_id)->get();
        $this->reset(['province_id', 'district_id']);
    }



    public function updatedProvinceId($value)
    {
        $this->province_id = str_pad((string)$value, 4, '0', STR_PAD_LEFT);
        $this->districts = District::where('province_id', $this->province_id)->get();
        $this->reset('district_id');
    }



    public function render()
    {
        return view('livewire.admin.company-edit');
    }
}
