<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Productatribute;
use App\Models\Initialinventory_productatribute;
use App\Models\Localproductatribute;
use Illuminate\Support\Facades\Auth;

class InventoryListdos extends Component
{

    public $mensaje;
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

/*      protected $rules = [
        'brand.name' => 'required',
        'brand.image'=>'image',
        'brand.state'=>'required',
    ]; */



    public function loadProducts(){
        $this->readyToLoad = true;
    }

    public function render()
    {

       /*  if ($this->readyToLoad) {
            $products = Productatribute::query()
                    ->with('productfamilie')
                    ->when($this->search, function($query){
                        return $query->where('codigo', 'like', '%' .$this->search. '%')
                               ->orWhereHas('productfamilie', function($q){
                                $q->where('name', 'like', '%' .$this->search. '%');
                               });
                    })
                    ->paginate(10);
        }else{
            $products =[];
        } */

        //$products =[];
        //dd(Auth()->user()->id);

        $localproductatributes = Localproductatribute::where('local_id', Auth()->user()->id)->paginate(5);
        //dd($localproductatributes);
        //$initialinventory_productatributes = Initialinventory_productatribute::all();
        ///$initialinventory_productatributes = Initialinventory_productatribute::paginate(5);

        //$initialinventory_productatributes = DB::table('initialinventory_productatribute')->paginate(5);

        return view('livewire.admin.inventory-listdos', compact('localproductatributes'));
    }


 // buscar y agregar producto por escaner y/o manual
 public function ScanCode($barcode,  $cant = 1)
 {

         //busca en la tabla productatribute
         $productatribute = Productatribute::where('codigo', $barcode)->first();

         //dd($productatribute);

         if ($productatribute == null || empty($productatribute)) {
                 $this->mensaje = 'El producto no está registrado';
         } else {
                //buscamos el producto en la tabla generada de muchos a muchos
                // Initialinventory_productatribute::find($productatribute->id);
                $initialinventory_productatribute = Initialinventory_productatribute::where('productatribute_id', $productatribute->id)->first();
                 //si es primera vez lo pone stock 1, sino aumenta el stock en 1
                if($initialinventory_productatribute==NULL){
                    $stock = 1;
                }else{
                    $stock = $initialinventory_productatribute->stock +1;
                }

                //falta poner dinamico el initial inventory ahora esta 1
                $productatribute->initialinventories()->sync([
                        1 => [
                            'stock' => $stock,
                        ],
                ]);


         }
 }



 public function updateQty($product, $cant)
 {
         // dd($product);
         if ($cant <= 0)
                 return;
         else
                 $this->updateQuantity($product, $cant);
 }


 public function updateQuantity($product, $cant)
 {
         //busco el producto
        // $product = Initialinventory_productatribute::where('productatribute_id', $product)->first();
         $product = Initialinventory_productatribute::find($product);
         //dd($cant);
         $product->stock = $cant;
         $product->save();
         //$product = Product::find($product, ['codigobarras']);
         //dd($product );


 }


 public function savestock(){
//guardamos stock en la tabla locale_productatribute



 }



}
