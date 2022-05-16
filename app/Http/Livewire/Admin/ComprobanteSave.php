<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Currency;
use App\Models\Tipocomprobante;
use Darryldecode\Cart\Facades\CartFacade as Cart;
//use App\Traits\CartTrait;
use App\Models\Product;



class ComprobanteSave extends Component
{
   // use CartTrait;
    public $search;
    public $total;
    public $mensaje;



	public function mount()
	{

		$this->total  = Cart::getTotal();
		//$this->itemsQuantity = Cart::getTotalQuantity();
		
		
	}


	// vaciar carrito
	public function limpiar()
	{
        Cart::clear();
        $this->total = Cart::getTotal();
	}


    public function render()
    {
        $cart = Cart::getContent()->sortBy('name');
        $customers =  Customer::all();
        $currencies =  Currency::all();
        $tipocomprobantes = Tipocomprobante::all();
        return view('livewire.admin.comprobante-save', compact('customers', 'currencies', 'tipocomprobantes', 'cart'));
    }

        public function getResultsProperty(){
                return Customer::where('nomrazonsocial', 'LIKE', '%'. $this->search .'%')->take(8)->get();
        }

        public function agregar($valor){
                $this->search = $valor;
        }

	// buscar y agregar producto por escaner y/o manual
	public function ScanCode($barcode, $cant = 1)
	{
		//$this->ScanearCode($barcode, $cant);

        $product = Product::where('codigobarras', $barcode)->first();

        if($product == null || empty($product))
        {
            $this->mensaje = 'El producto no está registrado';
        }  else {

                if($this->InCart($product->codigobarras))
                {
                        $this->IncreaseQuantity($product, $cant = 1);
                        return;
                }


                Cart::add($product->codigobarras, $product->name, $product->saleprice, $cant, $product->image);
                //Cart::add($product->id, $product->name, $product->saleprice, $cant, $product->image);
                $this->total = Cart::getTotal();
               // $this->itemsQuantity = Cart::getTotalQuantity();

        }



	}

    public function InCart($productId)
    {
        $exist = Cart::get($productId);
        if($exist)
                return true;
        else
                return false;
    }


     public function IncreaseQuantity($product, $cant = 1)
    {        
            $title ='';
            
            $exist = Cart::get($product->codigobarras);
            if($exist)
                    $title = 'Cantidad actualizada*';
            else
                    $title ='Producto agregado*';
    


            Cart::add($product->codigobarras, $product->name, $product->saleprice, $cant, $product->image);
    
            $this->total = Cart::getTotal();
            $this->itemsQuantity = Cart::getTotalQuantity();
    
            $this->emit('scan-ok', $title);
    
    } 


	// incrementar cantidad item en carrito
/* 	public function increaseQty(Product $product, $cant = 1)
	{		
		$this->IncreaseQuantity($product, $cant);	
	} */


    public function removeItem($productId)
    {
            Cart::remove($productId);
    
            $this->total = Cart::getTotal();
           // $this->itemsQuantity = Cart::getTotalQuantity();
    
           // $this->emit('scan-ok', 'Producto eliminado*');
    }


	// actualizar cantidad item en carrito
        public function updateQty($product, $price, $cant = 1)
	{
               // dd($product);
		if($cant <=0)
			$this->removeItem($product);                       
		else
			$this->updateQuantity($product, $price, $cant);	
	}


    public function updateQuantity($product, $price, $cant=1)
    {
            $title='';
            
            $product = Product::where('codigobarras', $product)->first();
            //$product = Product::find($product, ['codigobarras']);
            //dd($product );
            $exist = Cart::get($product->codigobarras);
            if($exist){
                $this->removeItem($product->codigobarras); 
            }
                          
            if($price > 0 and $cant > 0)
            {
                    Cart::add($product->codigobarras, $product->name, $price, $cant, $product->image);     
                    $this->total = Cart::getTotal();
                    // $this->itemsQuantity = Cart::getTotalQuantity();
    
                    // $this->emit('scan-ok', $title);
    
            }
                
                       
    
    
    }

    public function updatePrice($product, $price, $cant)
    {
            $title='';
            
            $product = Product::where('codigobarras', $product)->first();
            //$product = Product::find($product, ['codigobarras']);
            //dd($product );
            $exist = Cart::get($product->codigobarras);
            if($exist){
                $this->removeItem($product->codigobarras); 
            }
                          
            if($price > 0 and $cant > 0)
            {
                    Cart::add($product->codigobarras, $product->name, $price, $cant, $product->image);     
                    $this->total = Cart::getTotal();
                    // $this->itemsQuantity = Cart::getTotalQuantity();
    
                    // $this->emit('scan-ok', $title);
    
            }
                
                       
    
    
    }





}
