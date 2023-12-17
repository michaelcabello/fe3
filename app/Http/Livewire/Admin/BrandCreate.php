<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Brand;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Configuration;

class BrandCreate extends Component
{
    use AuthorizesRequests;
    use WithFileUploads;
    public $open = false;
    public $name, $state, $image, $identificador, $title, $description, $keywords, $order;

    public function mount()
    {
        $this->identificador = rand();
    }

    public function nuevo()
    {
        $this->identificador = rand();
        $this->open = true;
        $this->reset(['image']);
    }


    protected $rules = [
        'name' => 'required|unique:brands',
        'image' => '',
        //esta validaciones no es necesario al momento de crear nueva marca
        /* 'title'=>'',
        'description'=>'',
        'keywords'=>'', */

    ];


    public function save()
    {
        $this->authorize('create', new Brand);
        $this->validate();

        $urlimage = "/storage/brands/default.jpg";

        if ($this->image) {
            //validaremos la forma de guardar imagenes de marcas aws, store, servidor local o del hosting
            $configuration = Configuration::first();
            if ($configuration->typeimage == 3) {
                $image = $this->image->store('brands', 'public');
                $urlimage = Storage::url($image);
            } elseif ($configuration->typeimage == 2) {

            } elseif ($configuration->typeimage == 1) {

            }
        }


        //dd($this->state);

        $statee = ($this->state) ? 1 : 0;


        Brand::create([
            'name' => strtoupper($this->name),
            'slug' => Str::slug($this->name),
            'state' => $statee,
            'order' => $this->order,
            'title' => $this->title,
            'description' => $this->description,
            'keywords' => $this->keywords,
            //'image' => $image,
            'image' => $urlimage,
        ]);

        $this->reset(['open', 'name', 'image', 'title', 'description', 'keywords']);

        $this->emitTo('admin.brand-list', 'render');

        $this->emit('alert', 'La marca se creo correctamente');
    }



    public function render()
    {
        $this->authorize('create', new Brand);
        return view('livewire.admin.brand-create');
    }
}
