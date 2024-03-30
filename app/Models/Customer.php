<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    //relación de uno a muchos
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function comprobantes()
    {
        return $this->hasMany(Comprobante::class);
    }

    public function guias()
    {
        return $this->hasMany(Guia::class);
    }


    //relacion de uno a muchos inversa
    public function tipodocumento()
    {
        return $this->belongsTo(Tipodocumento::class);
    }
}
