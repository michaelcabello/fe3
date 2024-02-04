<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function sales(){
        return $this->hasMany(Sale::class);
    }

    public function comprobantes(){
        return $this->hasMany(Comprobante::class);
    }

}
