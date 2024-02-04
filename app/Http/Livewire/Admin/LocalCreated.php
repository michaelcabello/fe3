<?php

namespace App\Http\Livewire\Admin;
use App\Models\Local;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class LocalCreated extends Component
{
    use AuthorizesRequests;

    public $name, $codigopostal, $address, $email, $phone, $movil, $anexo, $company_id, $state;

    protected $rules = [
        'name' => 'required|unique:locals',
    ];

    public function save()
    {
        $this->authorize('create', new Local);
        $this->validate();

        //$urlimage = "/storage/brands/default.jpg";

        $statee = ($this->state) ? 1 : 0;


        Local::create([
            'name' => strtoupper($this->name),
            'codigopostal' => $this->codigopostal,
            'state' => $statee,
            'address' => strtoupper($this->address),
            'email' => $this->email,
            'phone' => strtoupper($this->phone),
            'movil' => strtoupper($this->movil),
            'anexo' => strtoupper($this->anexo),
            'company_id' => auth()->user()->employee->company->id,
        ]);

        $this->reset(['name']);

        //$this->emitTo('admin.local-list', 'render');

        $this->emit('alert', 'El Local se creo correctamente');

        // Redirección a la ruta '/locales'
        return redirect()->route('local.list');
    }



    public function cancel()
    {
        // Redirecciona a la ruta '/locales'
        return redirect()->route('local.list');
    }



    public function render()
    {
        return view('livewire.admin.local-created');
    }
}
