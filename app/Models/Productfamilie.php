<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productfamilie extends Model
{
    use HasFactory;

    const PRODUCTOTERMINADO = 1;
    const MERCADERIA = 2;
    const SERVICIO = 3;


    protected $fillable = [
        'name', 'description', 'state','order','simplecompuesto','tienenumerodeserie','genero', 'category_id','modelo_id','brand_id'
    ];

    //de uno a muchos
    public function productatributes()
    {
        return $this->hasMany(Productatribute::class);  
    }

}
