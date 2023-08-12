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
    public $selectedTallas, $selectedColores;
    public $atributes;

    public function mount(Productfamilie $product)
    {

        $this->productfamilie = $product;
        $uniqueAtributes = []; // Para mantener un seguimiento de los valores únicos

        foreach ($this->productfamilie->productatributes as $productatribute) {
            foreach ($productatribute->local_productatributes as $lpa) {
                if ($lpa->local_id == 1 && $lpa->stock) {
                   // $stock[$lpa->productatribute_id] = $lpa->stock;

                    $pa = Productatribute::find($lpa->productatribute_id);

                    foreach ($pa->atribute_productatributes as $atribute_productatribute) {
                        $groupAtributeId = $atribute_productatribute->atribute->groupatribute->id;
                        $groupAtributeName = $atribute_productatribute->atribute->groupatribute->name;
                        $atributeId = $atribute_productatribute->atribute->id;
                        $atributeName = $atribute_productatribute->atribute->name;

                        // Agregar valores únicos a los arreglos
                        if (!in_array($groupAtributeName, $uniqueAtributes)) {
                            $uniqueAtributes[] = $groupAtributeName;
                        }

                        if (!isset($this->atributes[$groupAtributeName])) {
                            $this->atributes[$groupAtributeName] = [];
                        }

                        $alreadyExists = false;
                        foreach ($this->atributes[$groupAtributeName] as $existingAtribute) {
                            if ($existingAtribute[0] === $atributeId) {
                                $alreadyExists = true;
                                break;
                            }
                        }

                        if (!$alreadyExists) {
                            $this->atributes[$groupAtributeName][] = [$atributeId, $atributeName];
                        }
                    }
                }
            }
        }

       //dd($this->atributes['Tallas'][0]);

    }



    public function updatedSelectedAttributes()
    {
        // Acceder a los valores seleccionados para el grupo "talla"
        $this->selectedTallas = $this->selectedAttributes['Tallas'];

        // Acceder a los valores seleccionados para el grupo "color"
        $this->selectedColores = $this->selectedAttributes['Colores'];

        dd($this->selectedTallas);
    }






    public function render()
    {
        $categories = Category::where('state', 1)->get();

        return view('livewire.product-detail', compact('categories'))->layout('layouts.appweb');

    }
}
