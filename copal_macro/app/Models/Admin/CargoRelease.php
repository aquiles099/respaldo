<?php

namespace App\Models\Admin;

use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Helpers\HConstants;

class CargoRelease extends Model
{
  /**
   *
   */
  protected $with = [
    'getUser',
    'getLastEvent'
  ];
  /**
  *
  */
  protected $hidden = [];
  /**
   *
   */
  public $incrementing = true;
  /**
   *
   */
  const TABLE = 'cargo_release';
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
  protected $fillable = [
    'last_event',
    'release_date',
    'release_time',
    'user',
    'contact_name',
    'contact_phone',
    'contact_country',
    'contact_region',
    'contact_city',
    'contact_address',
    'contact_postal_code',
    'aditional_information'
  ];
  /**
  *obtiene el usuario de la tupla
  */
  public function getUser() {
    return $this->hasOne('App\Models\Admin\User', 'id', 'user');
  }
  /**
  * Obtiene el evento actual
  */
  public function getLastEvent() {
    return $this->hasOne('App\Models\Admin\Event', 'id', 'last_event');
  }
  /**
  * retorna la cantidad de paquetes cargados
  */
  public function getCargoCount() {
    return DB::table('cargo_release_detail')->where('cargo_release', '=', $this->id)->count();
  }
  /**
  * Obtiene la suma total del volumen del cargo release
  */
  public function getTotalVolumeCargoRelease() {
    return DB::table('cargo_release_detail')->where('cargo_release', '=', $this->id)->sum('volume');
  }
  /**
  * Obtiene la suma total del peso del cargo release
  */
  public function getTotalWeightCargoRelease() {
    return DB::table('cargo_release_detail')->where('cargo_release', '=', $this->id)->sum('weight');
  }
  /**
   * Se genera el codigo
   */
  protected static function boot() {
    parent::boot();
    CargoRelease::creating(function(CargoRelease $cargoRelease) {
      if($cargoRelease->id == null || $cargoRelease->id == '' || $cargoRelease->id == -1) {
        $cargoRelease->id = DB::select('select seq_cargo_release_func() as id')[0]->id;
      }
      /**
      *
      */
      if($cargoRelease->code == null || $cargoRelease->code == '') {
        $cargoRelease->code = "CRL-".toBase36($cargoRelease->id);
      }
      /**
      * asignando fecha en start_at
      */
      if ($cargoRelease != null) {
        $cargoRelease->last_event = HConstants::EVENT_RECEIVED;
        $cargoRelease->start_at = date('Y-m-d');
      }
    });
  }
}
