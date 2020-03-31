<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Model;
use DB;

class Route extends Model
{
 /**
 *
 */
  protected $with = [
   'getTransport',
   'getOriginCountry',
   'getDestinyCountry',
   'getOriginCity',
   'getDestinyCity'
 ];
 /**
 *
 */
 public $incrementing = true;
 /**
 *
 */
 const TABLE = 'route';
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
    'code',
    'name',
    'transport',
    'origin_country',
    'origin_city',
    'destiny_country',
    'destiny_city',
    'description',
    'price'
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
   * se obtiene el transporte asociado a esa ruta
   */
   public function getTransport() {
       return $this->hasOne('App\Models\Admin\Transport', 'id', 'transport');
   }
   /**
   *
   */
   public function getOriginCountry() {
       return $this->hasOne('App\Models\Admin\Country', 'id', 'origin_country');
   }
   /**
   *
   */
   public function getDestinyCountry() {
       return $this->hasOne('App\Models\Admin\Country', 'id', 'destiny_country');
   }
   /**
   *
   */
   public function getOriginCity() {
       return $this->hasOne('App\Models\Admin\City', 'id', 'origin_city');
   }
   /**
   *
   */
   public function getDestinyCity() {
       return $this->hasOne('App\Models\Admin\City', 'id', 'destiny_city');
   }
   /**
    *,   'reduction' => "$this->value"
    */
   public function toOption() {
     return ['id' => $this->id, 'text' => "$this->name $this->country $this->city"];
   }
   /**
   * buscar por transporte
   */
    public function scopeByTransport($query, $value) {
       return $query->where('transport', '=', $value);
    }
     /**
      * Se genera el codigo
      */
     protected static function boot() {
       parent::boot();
       Route::creating(function(Route $route){
         if($route->id == null || $route->id == '' || $route->id == -1){
           $route->id = DB::select('select seq_route_func() as id')[0]->id;
         }
          /**
          *
          */
         if($route->code == null || $route->code == '') {
           $route->code = "ROU-".str_pad($route->id,5,'0',STR_PAD_LEFT);
         }
       });
     }
}
