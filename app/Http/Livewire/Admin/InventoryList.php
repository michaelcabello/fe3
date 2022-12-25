<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Storage;
use Illuminate\validation\Rule;
use Livewire\WithFileUploads;



class InventoryList extends Component
{


    use WithPagination;
    use WithFileUploads;
    public $search, $image, $brand, $state;
    public $sort='id';
    public $direction='desc';
    public $cant='10';
    public $open_edit = false;
    public $readyToLoad = false;//para controlar el preloader inicia en false

    protected $listeners = ['render', 'delete'];

    protected $queryString = [
        'cant'=>['except'=>'10'],
        'sort'=>['except'=>'id'],
        'direction'=>['except'=>'desc'],
        'search'=>['except'=>''],
    ];


    public function mount(){
       // $this->identificador = rand();
       // $this->brand = new Brand();//se hace para inicializar el objeto e indicar que image es
       // $this->image ="";
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




    public function render()
    {


        return view('livewire.admin.inventory-list');
    }













}
