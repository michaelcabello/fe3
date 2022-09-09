<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
/*     protected $fillable = [
        'name', 'url', 'image','description', 'state'
    ]; */
    protected $fillable = [ 'name'];



    //Relacion uno a muchos
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




//est es para el recursivo    
/*     public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function childrenCategories()
    {
        return $this->hasMany(Category::class)->with('categories');
    } */

}
