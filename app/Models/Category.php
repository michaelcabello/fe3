<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Productfamilie;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
/*     protected $fillable = [
        'name', 'slug', 'state','image'
    ]; */



    //Relacion uno a muchos
/*     public function productfamilies(){
        return $this->hasMany(Productfamilie::class);
    } */


      public function subcategories(){
        return $this->hasMany(Subcategory::class);
    }

    //Relacion muchos a muchos
      public function brands(){
        return $this->belongsToMany(Brand::class);
    }

    //Relacion atravez de
      public function productfamilies(){
        return $this->hasManyThrough(Productfamilie::class, Subcategory::class);
    }

    //URL AMIGABLES
     public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = $name;
        $this->attributes['slug'] = str::slug($name);

    }


//est es para el recursivo
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function childrenCategories()
    {
        return $this->hasMany(Category::class)->with('categories');
    }
//est es para el recursivo

}
