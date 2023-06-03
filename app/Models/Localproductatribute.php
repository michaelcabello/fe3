<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Localproductatribute extends Model
{
    use HasFactory;

    protected $fillable = ['productatribute_id', 'local_id', 'pricesale', 'pricewholesale', 'pricesalemin', 'stock', 'stockmin'];
    // protected $guarded = ['productatribute_id', 'local_id','created_at', 'updated_at'];

    protected $table = "local_productatribute";
    //indicamos el primarykey compuesto
   // protected $primaryKey = ['productatribute_id', 'local_id'];
    //ponemos incremento en falso porque inhabilitamod id()
    protected $primaryKey = 'id';
   // protected $primaryKey = null;
    public $incrementing = false;


    //protected $primaryKey = ['local_id', 'productatribute_id'];

/*     public function getKeyName()
    {
        return ['local_id','productatribute_id',];
    } */

/*     public function getLivewireKeyName()
    {
        return $this->getAttribute('local_id') . '-' . $this->getAttribute('productatribute_id');
    } */




    protected $casts = [
        'local_id' => 'integer',
        'productatribute_id' => 'integer',
        // Otros campos y tipos de datos
    ];

    public function getLivewireKeyName()
    {
        return $this->getAttribute('local_id') . '-' . $this->getAttribute('productatribute_id');
    }


/*     protected function setKeysForSaveQuery($query)
    {
        foreach ($this->getKeyName() as $keyName) {
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    } */


/*     protected function getKeyForSaveQuery($keyName = null)
    {
        if (is_null($keyName)) {
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }
 */


 /*    public function getLivewireKeyName()
    {
        return $this->getAttribute('productatribute_id') . '-' . $this->getAttribute('local_id');
    } */

    //de uno a muchos inversa
    public function productatribute()
    {
        return $this->belongsTo(Productatribute::class, 'productatribute_id');
    }

    //de muchos a muchos
    public function inventories()
    {
        return $this->belongsToMany(Inventory::class)->withTimestamps()->withPivot('stock');
    }





 /*    public function getKeyType()
    {
        return 'int';
    }
 */

/*     public function getCasts()
    {
        $casts = $this->casts;

        if ($this->getIncrementing()) {
            foreach ($this->getKeyName() as $keyName) {
                $casts[$keyName] = $this->getKeyType();
            }
        }

        return $casts;
    } */
}
