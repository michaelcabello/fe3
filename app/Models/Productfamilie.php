<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productfamilie extends Model
{
    use HasFactory;


    protected $fillable = [
        'name', 'description', 'state','order','simplecompuesto','tienenumerodeserie','genero', 'category_id','modelo_id','brand_id'
    ];

    //de uno a muchos
    public function productatributes()
    {
        return $this->hasMany(Productatribute::class);  
    }

}
