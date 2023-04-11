<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Brand;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BrandCreate extends Component
{
    use AuthorizesRequests;
    use WithFileUploads;
    public $open = false;
    public $name, $state, $image, $identificador;

    public function mount(){
        $this->identificador=rand();
    }

    public function nuevo(){
        $this->identificador=rand();
        $this->open = true;
        $this->reset(['image']);

    }


    protected $rules = [
        'name'=> 'required|unique:brands',
        'image'=>'required|image|max:2048',
    ];


    public function save(){
        $this->authorize('create', new Brand);
        $this->validate();

        $image = $this->image->store('brands', 'public');
        $urlimage = Storage::url($image);
        //dd($this->state);

        $statee = ($this->state) ? 1 : 0 ;


        Brand::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'state' => $statee,
            //'image' => $image,
            'image' => $urlimage,
        ]);

        $this->reset(['open','name','image']);

        $this->emitTo('admin.brand-list','render');

        $this->emit('alert','La marca se creo correctamente');
    }



    public function render()
    {
        $this->authorize('create', new Brand);
        return view('livewire.admin.brand-create');
    }



}
