<?php

namespace App\Models\Admin;

use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Prealert extends Model {
  use SoftDeletes;
  /**
   *
   */
  protected $with = [
    'getPackage',
    'getCourier',
    'getFile',
    'getUser'
  ];
  /**
   *
   */
  public $incrementing = true;
  /**
   *
   */
  const TABLE = 'prealert';
  /**
   *
   */
  protected $table = self::TABLE;
  /**
   *
   */
  public $timestamps = true;
  /**
   *
   */
  protected $hidden = [

  ];
  /**
   *
   */
  protected $fillable = [
    'user',
    'order_service',
    'package',
    'provider',
    'courier',
    'complete',
    'value',
    'content',
    'date_arrived',
    'file',
    'large',
    'height',
    'width',
    'weight',
    'volumetricweightm1',
    'volumetricweighta1',
    'type'
  ];
  /**
   *
   */
  public function getUser() {
      return $this->hasOne('App\Models\Admin\User', 'id', 'user');
  }
  /**
   *
   */
  public function getPackage() {
      return $this->hasOne('App\Models\Admin\Package', 'id', 'package');
  }
  /**
   *
   */
  public function getCourier() {
      return $this->hasOne('App\Models\Admin\Courier', 'id', 'courier');
  }
  /**
  *
  */
  public function getFile() {
      return $this->hasOne('App\Models\Admin\File', 'id', 'file');
  }
  /**
  *
  */
  public function scopeByOrderService($query, $value) {
    return $query->where('order_service', '=', $value);
  }
  /**
  *
  */
  public function scopeByuser($query, $value) {
    return $query->where('user', '=', $value);
  }
  /**
  *
  */
  public function scopeByDateArrived($query, $value) {
    return $query->where('date_arrived', '=', $value);
  }
  /**
   * Se genera el codigo
   */
  protected static function boot() {
    parent::boot();
    Prealert::creating(function(Prealert $prealert) {
      if($prealert->id == null || $prealert->id == '' || $prealert->id == -1) {
        $prealert->id = DB::select('select seq_prealert_func() as id')[0]->id;
      }
      // conversion a hexadecimal
      if($prealert->code == null || $prealert->code == '') {
        $prealert->code = "PLT-".str_pad($prealert->id,5,'0',STR_PAD_LEFT);
      }
    });
  }
}
