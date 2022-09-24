<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'state','image'
    ];

    
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = $name;
        $this->attributes['slug'] = str::slug($name);
    }
  

    //Relacion uno a muchos
    public function productfamilies(){
        return $this->hasMany(Productfamilie::class);
    }

    //Relacion muchos a muchos
     public function categories(){
        return $this->belongsToMany(Category::class);
    }




}
