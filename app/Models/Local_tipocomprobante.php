<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Local_tipocomprobante extends Model
{
    use HasFactory;


    //relacion de uno a muchos
     public function comprobantes(){
        return $this->hasMany(Comprobante::class);
    } 


}
