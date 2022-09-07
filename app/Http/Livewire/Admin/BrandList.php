<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Brand;
use Illuminate\Support\Facades\Storage;
use Illuminate\validation\Rule;
use Livewire\WithFileUploads;

class BrandList extends Component
{

    use WithPagination;
    use WithFileUploads;  
    public $search, $image, $brand, $state, $flat;
    public $sort='id';
    public $direction='desc';
    public $cant='10';
    public $open_edit = false;
    public $readyToLoad = false;//para cntrolar el preloader

    protected $listeners = ['render', 'delete'];

    protected $queryString = [
        'cant'=>['except'=>'10'],
        'sort'=>['except'=>'id'],
        'direction'=>['except'=>'desc'],
        'search'=>['except'=>''],
    ];    


    public function mount(){
        $this->identificador = rand();
        $this->brand = new Brand();//se hace para inicializar el objeto e indicar que image es
        $this->image ="";
    }

    public function updatingSearch(){
        $this->resetPage();
        //RESETEA la paginación, updating() cuando se cambia una de las propiedades  updatingSearch() cuando se cambia la propiedad search
    }


/*       'brand.name'=> 'required',Rule::unique('brands')->ignore($this->brand->id) */

     protected $rules = [
        'brand.name' => 'required',
        'brand.image'=>'image',
        'brand.state'=>'required',
    ];  


    public function loadBrands(){
        $this->readyToLoad = true;
    }

    public function render()
    {
        if ($this->readyToLoad) {
            $brands = Brand::where('name', 'like', '%' .$this->search. '%')
                ->when($this->state, function($query){
                    return $query->where('state',1);
                })
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);
               
        }else{
            $brands =[];
            $this->flat =true;

        }
        return view('livewire.admin.brand-list', compact('brands'));
    }

    public function order($sort){
        if($this->sort == $sort){
            if($this->direction == 'desc'){
                $this->direction = 'asc';
            }else{
                $this->direction = 'desc';
            }
        }else{
            $this->sort = $sort;
            $this->direction = 'asc';
        }

    }


    public function activar(Brand $brand){
        $this->brand = $brand;

        $this->brand->update([
            'state' => 1
        ]);
    }

    public function desactivar(Brand $brand){
        $this->brand = $brand;

        $this->brand->update([
            'state' => 0
        ]);
    }

    public function delete(Brand $brand){
        $brand->delete();
    }

    public function edit(Brand $brand){
        $this->brand = $brand;
        $this->open_edit = true;

    }

    public function cancelar(){
        $this->reset('open_edit', 'image');
        $this->identificador = rand();
        //$this->open_edit = false;
    }

    public function update(){
        //$this->validate();

        if($this->image){
            Storage::delete([$this->brand->image]);
            $this->brand->image = Storage::url($this->image->store('brands', 'public'));
        } 

        $this->brand->save();
        $this->reset('open_edit', 'image');
        $this->identificador = rand();
        //$this->emitTo('show-brands', 'render');
        $this->emit('alert','La marca se modificó correctamente');

    }


}
