<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ncboleta extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    //de uno a muchos inversa
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }


    /*relcion de uno a uno*/
    public function comprobante()
    {
        return $this->belongsTo(Comprobante::class);
    }

}
