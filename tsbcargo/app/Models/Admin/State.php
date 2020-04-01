<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class State extends Model
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
  const TABLE = 'state';
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
       State::creating(function(State $state){
         if($state->id == null || $state->id == '' || $state->id == -1){
           $state->id = DB::select('select seq_state_func() as id')[0]->id;
         }
          /**
          *
          */
         if($state->code == null || $state->code == '') {
           $state->code = "STA-".str_pad($state->id,5,'0',STR_PAD_LEFT);
         }
       });
     }
}
