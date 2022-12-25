<?php
namespace App\Http\Livewire\Admin;

use App\Models\Brand;
use Livewire\Component;
use App\Models\Category;
use App\Models\Configuration;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\Productfamilie;

class ProductList extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $search, $image, $product, $state;
    public $sort='id';
    public $direction='desc';
    public $cant='10';
    public $open_edit = false;
    public $readyToLoad = false;//para controlar el preloader
    public $withcategory;//esta opcion vienen de configuracion 1 es con categoria
    public $category;

    protected $listeners = ['render', 'delete'];

    protected $queryString = [
        'cant'=>['except'=>'10'],
        'sort'=>['except'=>'id'],
        'direction'=>['except'=>'desc'],
        'search'=>['except'=>''],
    ];


    public function mount(){
        $this->identificador = rand();
       // $this->brand = new Brand();//se hace para inicializar el objeto e indicar que image es
        $this->image ="";
        $this->withcategory = Configuration::pluck('withcategory');//es un array y el valor se guarda en this->withcategory[0]
        if(!$this->withcategory[0]){//esto es sin categoria
            $this->category = Category::where('id', 1)->first();
        }


    }

    public function updatingSearch(){
        $this->resetPage();
        //RESETEA la paginación, updating() cuando se cambia una de las propiedades  updatingSearch() cuando se cambia la propiedad search
    }


/*       'brand.name'=> 'required',Rule::unique('brands')->ignore($this->brand->id) */

     protected $rules = [
        'product.name' => 'required',
        'product.image'=>'image',
        'product.state'=>'required',
    ];


    public function loadProducts(){
        $this->readyToLoad = true;
    }

    public function render()
    {


/*         if ($this->readyToLoad) {
            $products = Productfamilie::where('name', 'like', '%' .$this->search. '%')
                ->when($this->state, function($query){
                    return $query->where('state',1);
                })
                ->orderBy($this->sort, $this->direction)
                ->paginate($this->cant);

        }else{
            $products =[];

        } */

        return view('livewire.admin.product-list');


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


    public function activar(Productfamilie $product){
        $this->product = $product;

        $this->product->update([
            'state' => 1
        ]);
    }

    public function desactivar(Productfamilie $product){
        $this->product = $product;

        $this->product->update([
            'state' => 0
        ]);
    }

    public function delete(Productfamilie $product){
        $product->delete();
    }



/*     public function cancelar(){
        $this->reset('open_edit', 'image');
        $this->identificador = rand();
        //$this->open_edit = false;
    } */






}



