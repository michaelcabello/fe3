<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boleta extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];


    //uno a muchos inversa
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

}
