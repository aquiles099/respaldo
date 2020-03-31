<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Model;
use DB;

class Vessel extends Model
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
  const TABLE = 'vessel';
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
     'flag',
     'country',
     'city'
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
   * Formateando flag
   */
   public function setFlagAttribute($flag) {
      if (!empty($flag)) {
         $this->attributes['flag'] = strtolower($flag);
      }
    }
    /**
    * obtener pais
    */
    public function getCountry() {
        return $this->hasOne('App\Models\Admin\Country', 'id', 'country');
    }
    /**
    * obtener pais
    */
    public function getCity() {
        return $this->hasOne('App\Models\Admin\City', 'id', 'city');
    }
    /**
    * buscar por pais
    */
     public function scopeByCountry($query, $value) {
        return $query->where('country', '=', $value);
     }
     /**
     * buscar por ciudad
     */
      public function scopeByCity($query, $value) {
         return $query->where('city', '=', $value);
      }
    /**
     * Se genera el codigo
     */
    protected static function boot()
    {
      parent::boot();
      Vessel::creating(function(Vessel $vessel){
        if($vessel->id == null || $vessel->id == '' || $vessel->id == -1){
          $vessel->id = DB::select('select seq_vessel_func() as id')[0]->id;
        }
         /**
         *
         */
        if($vessel->code == null || $vessel->code == '') {
          $vessel->code = "VES-".toBase36($vessel->id);
        }
      });
    }
}
