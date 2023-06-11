<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Currency;
use App\Models\Productatribute;
use App\Models\Supplier;
use App\Models\Tipocomprobante;
use Darryldecode\Cart\Facades\CartFacade as Cart;
//use Gloudemans\Shoppingcart\Facades\Cart;

class ShoppingCreate extends Component
{

    public $mensaje;
    public $total;
    public $itemsQuantity;



    public function mount()
    {
        $this->total  = Cart::getTotal(); //inicializxa el total del comprobante
    }


    // buscar y agregar producto por escaner y/o manual
    public function ScanCode($barcode,  $cant = 1)
    {
        //$this->ScanearCode($barcode, $cant);
        $product = Productatribute::where('codigo', $barcode)->first();
        //dd($product);
        //if ($product == null || empty($product))
        if ($product == null || empty($product)) {
            $this->mensaje = 'El producto no está registrado';
            //$this->emit('alert', $this->mensaje);
            //$title = 'El producto no está registrado';
        } elseif ($product->pricesale === null) {
            $this->mensaje = 'El producto no tiene precio';
           // $this->emit('alert', $this->mensaje);
        } else {

            if ($this->InCart($product->codigo)) {
                $this->IncreaseQuantity($product, $cant = 1);
                return;
            }

            //ingresamos al producto nuevo
            Cart::add($product->codigo, $product->slug, $product->pricesale, $cant, 'hola');
            //$this->mensaje = 'Producto agregado';
            //Cart::add($product->id, $product->name, $product->saleprice, $cant, $product->image);
            $this->total = Cart::getTotal();
            // $this->itemsQuantity = Cart::getTotalQuantity();
           // $this->emit('alert', $this->mensaje);
        }
    }

    public function InCart($productId)
    {
        $exist = Cart::get($productId);
        if ($exist)
            return true;
        else
            return false;
    }


    public function IncreaseQuantity($product, $cant = 1)
    {
        //$title = '';

        $exist = Cart::get($product->codigo); //exist es el carrito
        //dd($exist->price);
        if ($exist) {
            $this->mensaje = 'Cantidad actualizada';
            $price = $exist->price; //price es la columna del carrito
        } else {
            //$title = 'Producto agregado';
            $price = $product->pricesale;
        }


        //importante si el producto ya existe el add adiciona un producto no es necesario poner cant = cant +1
        Cart::add($product->codigo, $product->slug, $price, $cant, 'hola2');
        //$title = 'producto agregado';
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();

        $this->emit('alert', $this->mensaje);
    }




    public function render()
    {

        $cart = Cart::getContent()->sortBy('name');
        $suppliers = Supplier::all();
        $currencies = Currency::all();
        $tipocomprobantes = Tipocomprobante::all();
        $this->total  = Cart::getTotal();
        return view('livewire.admin.shopping-create', compact('suppliers', 'currencies', 'tipocomprobantes', 'cart'));
    }

    // vaciar carrito
    public function limpiar()
    {
        Cart::clear();
        $this->total = Cart::getTotal();
    }

    // actualizar cantidad item en carrito
    public function updateQty($product, $price, $cant = 1)
    {
        //dd($product);
        if ($cant <= 0)
            $this->removeItem($product);
        else
            $this->updateQuantity($product, $price, $cant);
    }


    public function removeItem($product)
    {
            Cart::remove($product);

            $this->total = Cart::getTotal();
            // $this->itemsQuantity = Cart::getTotalQuantity();

            // $this->emit('scan-ok', 'Producto eliminado*');
    }



    public function updateQuantity($product, $price, $cant = 1)
    {
        //$title = '';

        $product = Productatribute::where('codigo', $product)->first();

        //dd( $product );
        $exist = Cart::get($product->codigo);
        if ($exist) {
            $this->removeItem($product->codigo);
        }

        if ($price > 0 and $cant > 0) {
            //$product->images->url
            Cart::add($product->codigo, $product->slug, $price, $cant, 'hola');
            $this->total = Cart::getTotal();
            // $this->itemsQuantity = Cart::getTotalQuantity();

            // $this->emit('scan-ok', $title);

        }
    }




    public function updatePrice($product, $price, $cant)
    {
        //$title = '';

        //dd($price);

        $product = Productatribute::where('codigo', $product)->first();

        //$product = Product::find($product, ['codigobarras']);
        //dd($product );
        $exist = Cart::get($product->codigo);
        if ($exist) {
            $this->removeItem($product->codigo);
        }

        if ($price > 0 and $cant > 0) {
            Cart::add($product->codigo, $product->slug, $price, $cant, 'hola');
            $this->total = Cart::getTotal();
            // $this->itemsQuantity = Cart::getTotalQuantity();

            // $this->emit('scan-ok', $title);

        }
    }


    public function save()
    {
        //dd("gravando");
        //guardamos la cabecera



        //guardamos el detalle
    }


}
