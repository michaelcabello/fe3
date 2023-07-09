<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Tipocomprobante;
use Illuminate\Support\Facades\DB;
use App\Models\Localproductatribute;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use App\Models\Boleta_local_productatribute;
use App\Models\Boleta;


class SaleCreate extends Component
{

    public $mensaje;
    public $itemsQuantity;
    public $customer_id="", $fechaemision, $fechavencimiento, $formadepago="", $tipocomprobante_id="", $serienumero, $currency_id="";
    public $photo, $nota, $subtotal, $igv, $total, $tipodecambio_id;
    public $serie, $numero, $search, $boleta;

    //public $cartVentas;

/*     public function mount(Boleta $boleta)
    {
        $this->boleta = $boleta;
        $this->cartVentas = $cartVentas;
        $this->cartVentas = new Cart();
    } */

    public function mount(Boleta $boleta)
    {
        $this->boleta = $boleta;

/*         $this->cartVentas = new Cart(
            'cart',
            session(),
            app(Dispatcher::class),
            'default',
            'cart_content'
        ); */


    }




    public function ScanCode($barcode,  $cant = 1)
    {
        $this->search = $barcode;


        //buscamos el producto en Localproductatribute
        $local_productatribute = Localproductatribute::with('productatribute')
            ->where('local_id', Auth()->user()->employee->local->id)
            ->whereHas('productatribute', function ($query) {
                $query->where('codigo', $this->search);
            })->first();

        //dd($local_productatribute->productatribute->codigo);


        if ($local_productatribute == null || empty($local_productatribute)) {
            $this->mensaje = 'El producto no está registrado';
            //$this->emit('alert', $this->mensaje);
            //$title = 'El producto no está registrado';
        } elseif ($local_productatribute->productatribute->pricesale === null) {
            $this->mensaje = 'El producto no tiene precio';
           // $this->emit('alert', $this->mensaje);
        } else {

            if ($this->InCart($local_productatribute->productatribute->codigo)) {
                $this->IncreaseQuantity($local_productatribute->productatribute, $cant = 1);
                return;
            }

            //ingresamos al producto nuevo
            Cart::add($local_productatribute->productatribute->codigo, $local_productatribute->productatribute->slug, $local_productatribute->productatribute->pricesale, $cant, $local_productatribute->productatribute->id);

            $this->total = Cart::getTotal();
            //$total = Cart::getTotal();

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
        //Cart::add($product->codigo, $product->slug, $price, $cant, $product->id);
        Cart::add($product->codigo, $product->slug, $price, $cant, $product->id);
        //$title = 'producto agregado';
        $this->total = Cart::getTotal();
        $this->itemsQuantity = Cart::getTotalQuantity();

        $this->emit('alert', $this->mensaje);
    }






    public function render()
    {
        $cart = Cart::getContent()->sortBy('name');
        $customers = Customer::all();
        $currencies = Currency::all();
        $tipocomprobantes = Tipocomprobante::all();
        $this->total  = Cart::getTotal();

        return view('livewire.admin.sale-create', compact('customers', 'currencies', 'tipocomprobantes', 'cart'));
    }
}
