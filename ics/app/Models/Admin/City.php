<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Model;
use DB;

class City extends Model
{
  /**
  *
  */
   protected $with = [

  ];
  /**
  *
  */
  public $incrementing = true;
  /**
  *
  */
  const TABLE = 'city';
  /**
   * @var string
   */
  protected $table = self::TABLE;
  /**
  * @var bool
  */
  public $timestamps = true;
  /**
  * @var array
  */
  protected $hidden = [

  ];
  /**
  *
  */
   protected $fillable = [
     'name',
     'country',
     'state',
     'description'
  ];
  /**
  * Formateando nombre
  */
  public function setNameAttribute($name) {
     if (!empty($name)) {
        $this->attributes['name'] = strtolower($name);
     }
   }
   /**
   * Formateando descripcion
   */
   public function setDescriptionAttribute($description) {
      if (!empty($description)) {
         $this->attributes['description'] = strtolower($description);
      }
    }
    /**
    * se obtiene el pais asociado a esa ciudad
    */
    public function getCountry() {
        return $this->hasOne('App\Models\Admin\Country', 'id', 'country');
    }
    /**
     *
     */
    public function toOption() {
      return ['id' => $this->id, 'text' => "$this->name - ".$this->getCountry->name];
    }
    /**
    * buscar por pais
    */
     public function scopeByCountry($query, $value) {
        return $query->where('country', '=', $value);
     }
     /**
      * Se genera el codigo
      */
     protected static function boot()
     {
       parent::boot();
       City::creating(function(City $city){
         if($city->id == null || $city->id == '' || $city->id == -1){
           $city->id = DB::select('select seq_city_func() as id')[0]->id;
         }
          /**
          *
          */
         if($city->code == null || $city->code == '') {
           $city->code = "CIT-".str_pad($city->id,5,'0',STR_PAD_LEFT);
         }
       });
     }
}
