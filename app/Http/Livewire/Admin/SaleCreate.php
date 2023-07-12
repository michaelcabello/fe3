<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Tipocomprobante;
use Illuminate\Support\Facades\DB;
use App\Models\Localproductatribute;
//use Darryldecode\Cart\Facades\CartFacade as Cart;
//use App\Models\Boleta_local_productatribute;
//use App\Models\Boleta;
//use App\Http\Livewire\Admin\SalesCart;
use Illuminate\Support\Collection;

class SaleCreate extends Component
{

    public $mensaje;
    public $itemsQuantity;
    public $customer_id="", $fechaemision, $fechavencimiento, $formadepago="", $tipocomprobante_id="", $serienumero, $currency_id="";
    public $photo, $nota, $subtotal, $igv, $total, $tipodecambio_id;
    public $serie, $numero, $search, $boleta;

    public $salesCartInstance = 'salesCart';
    public $cart;

    public function mount()
    {
        $this->cart = session('cart', new Collection());
        $this->listeners['cartUpdated'] = 'updatedCart';
        //$items =  $this->cart ;
       // $this->total = 0;
    }


    public function addToCart($productId, $name, $price, $quantity = 1)
    {
        if ($this->cart) {
            if ($this->cart->has($productId)) {
                $product = $this->cart->get($productId);
                $product['quantity'] += $quantity;
            } else {
                $product = [
                    'id' => $productId,
                    'name' => $name,
                    'price' => $price,
                    'quantity' => $quantity,
                ];
            }

            $this->cart->put($productId, $product);
            session(['cart' => $this->cart]);
        }
    }

    public function getTotal()
    {
        $this->total = 0;

        if ($this->cart) {
            foreach ($this->cart as $product) {
                $this->total += $product['price'] * $product['quantity'];
            }
        }

        return $this->total;
    }




    public function ScanCode($barcode,  $quantity = 1)
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

            $this->addToCart(
                $local_productatribute->productatribute->codigo,
                $local_productatribute->productatribute->slug,
                $local_productatribute->productatribute->pricesale,
                $quantity
            );
            $this->total = $this->getTotal();


        }
    }


    public function removeFromCart($productId)
    {
        if ($this->cart->has($productId)) {
            $this->cart->forget($productId);
            session()->put('cart', $this->cart);
        }
    }

    public function updateQuantity($productId, $quantity)
    {
        if ($this->cart->has($productId)) {
            $product = $this->cart->get($productId);
            $product['quantity'] = $quantity;
            $this->cart->put($productId, $product);
            session()->put('cart', $this->cart);
        }
    }

    public function clearCart()
    {
        session()->forget('cart');
        $this->cart = new Collection();
    }

    public function updated($propertyName)
    {
        if ($propertyName === 'cart') {
            $this->emit('cartUpdated');
        }
    }

    public function updatedCart()
    {
        $this->emit('cartUpdated');
    }


    public function render()
    {
        //$cart = Cart::getContent()->sortBy('name');
        $cart = $this->cart;
        //$total = $this->total;
        $customers = Customer::all();
        $currencies = Currency::all();
        $tipocomprobantes = Tipocomprobante::all();
        $this->total = $this->getTotal();
       //$this->listeners['cartUpdated'] = 'updatedCart';

        return view('livewire.admin.sale-create', compact('customers', 'currencies', 'tipocomprobantes', 'cart'));
    }
}
