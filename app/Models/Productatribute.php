<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productatribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo', 'price','productfamilie_id','state'
    ];

    //de uno a muchos inversa
    public function productfamilie()
    {
        return $this->belongsTo(Productfamilie::class);  
    }


    //Relacion muchos a muchos//atributes se esta usando en la clase Groupatributes
    public function atributes(){
        return $this->belongsToMany(Atribute::class);
    }


}
