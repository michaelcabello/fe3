<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Productatribute;
use App\Models\Productfamilie;

class ProductDetail extends Component
{
    public $productfamilie;
    public $selectedAttributes = [];
    public $tallas=[];
    public $colores=[];
    public $tallas_id;
    public $colores_id;
    public $selectedTallas, $selectedColores;
    public $atributes;


    protected $rules = [
        'tallas_id' => 'required',
        'colores_id' => 'required',
    ];



    public function mount(Productfamilie $product)
    {

        $this->tallas_id = "";
        $this->productfamilie = $product;
        //$uniqueAtributes = []; // Para mantener un seguimiento de los valores únicos

        foreach ($this->productfamilie->productatributes as $productatribute) {
            $i=0;
            foreach ($productatribute->local_productatributes as $lpa) {
                $i=$i+1;
                if ($lpa->local_id == 1 && $lpa->stock) {
                   // $stock[$lpa->productatribute_id] = $lpa->stock;

                    $pa = Productatribute::find($lpa->productatribute_id);

                    foreach ($pa->atribute_productatributes as $atribute_productatribute) {
                        $groupAtributeId = $atribute_productatribute->atribute->groupatribute->id;
                        $groupAtributeName = $atribute_productatribute->atribute->groupatribute->name;
                        $atributeId = $atribute_productatribute->atribute->id;
                        $atributeName = $atribute_productatribute->atribute->name;

                        // Agregar valores únicos a los arreglos
                        /* if (!in_array($groupAtributeName, $this->tallas)) {
                            if($i==1){
                                $this->tallas[] = $groupAtributeName;
                            }
                        }

                        if (!in_array($groupAtributeName, $this->colores)) {
                            if($i==2){
                                $this->colores[] = $groupAtributeName;
                            }
                        } */


                       /*  if (!isset($this->atributes[$groupAtributeName])) {
                            $this->atributes[$groupAtributeName] = [];
                        } */

                        if($groupAtributeName=='Tallas'){
                            if (!in_array($atributeName, $this->tallas)) {
                                $this->tallas[$atributeId] = $atributeName;
                            }
                        }

                        if($groupAtributeName=='Colores'){
                            if (!in_array($atributeName, $this->colores)) {
                                $this->colores[$atributeId] = $atributeName;
                            }
                        }

                    }
                }
            }
        }

        //dd($this->colores_id);
        //dd($this->tallas_id);

        $this->colores_id="color";
        $this->tallas_id="talla";
    }


    public function render()
    {
        $categories = Category::where('state', 1)->get();

        return view('livewire.product-detail', compact('categories'))->layout('layouts.appweb');

    }
}
