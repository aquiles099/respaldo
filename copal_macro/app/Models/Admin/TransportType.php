<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Model;
use DB;

class TransportType extends Model
{
  /**
  *
  */
   protected $with = [
    'getTransport'
  ];
  /**
  *
  */
  public $incrementing = true;
  /**
  *
  */
  const TABLE = 'transport_type';
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
     'transport',
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
    *
    */
    public function getTransport() {
        return $this->hasOne('App\Models\Admin\Transport', 'id', 'transport');
    }
    /**
     *
     */
    public function toOption() {
      return ['id' => $this->id, 'text' => "$this->name"];
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
     protected static function boot()
     {
       parent::boot();
       TransportType::creating(function(TransportType $transport_type){
         if($transport_type->id == null || $transport_type->id == '' || $transport_type->id == -1){
           $transport_type->id = DB::select('select seq_transport_type_func() as id')[0]->id;
         }
          /**
          *
          */
         if($transport_type->code == null || $transport_type->code == '') {
           $transport_type->code = "TTP-".toBase36($transport_type->id);
         }
       });
     }
}
