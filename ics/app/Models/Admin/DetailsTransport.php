<?php

namespace App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hash;
use DB;

class DetailsTransport extends Model
{
  use SoftDeletes;
    /**
   *
   */
  const TABLE = 'detailstransport';

   /**
   *
   */
  public $incrementing = true;

  /**
   * @var string
   */
  protected $table = self::TABLE;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'id',
    'code',
    'name',
    'description',
    'transport'
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
  public function scopeByTransport($query, $value) {
      return $query->where('transport', '=', $value);
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
    return ['id' => $this->id, 'text' => "$this->name - ".$this->getTransport->spanish];
  }
   /**
    * Se genera el codigo
    */
   protected static function boot() {
     parent::boot();
     DetailsTransport::creating(function(DetailsTransport $details_transport) {

       if($details_transport->id == null || $details_transport->id == '' || $details_transport->id == -1) {
         $details_transport->id = DB::select('select seq_detailstransport_func() as id')[0]->id;
       }
        /**
        *
        */
       if($details_transport->code == null || $details_transport->code == '') {
         $details_transport->code = "PRT-".str_pad($details_transport->id,5,'0',STR_PAD_LEFT);
       }
     });
   }
}
