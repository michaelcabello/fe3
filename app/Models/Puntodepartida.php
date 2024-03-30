<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puntodepartida extends Model
{
    use HasFactory;

    public function guias()
    {
        return $this->hasMany(Guia::class);
    }
}
