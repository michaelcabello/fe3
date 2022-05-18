<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{
    use HasFactory;


    //relacion de uno a muchos inversa
    public function local_tipocomprobante(){
        return $this->belongsTo(Local_tipocomprobante::class);
    }



}
