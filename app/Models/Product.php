<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    //relacion de uno a muchos inversa
    public function um()
    {
        return $this->belongsTo(Um::class);
    }

    public function tipoafectacion()
    {
        return $this->belongsTo(Tipoafectacion::class);
    }

}
