<?php

namespace App\Models\Admin;

use App\Models\Model;
use Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Models\Admin\Client;
use App\Models\Admin\User;
use Carbon\Carbon;
use App\Helpers\HConstants;
/**
 * User: vchacin
 */
class Package extends Model {

  /**
   *
   */
  protected $with = [
    'getClient',
    'getCourier',
    'getToClient',
    'getToUser',
    'getType',
    'getCategory',
    'getLastEvent',
    'getOficce'
  ];

  /**
   *
   */
  public $incrementing = true;

  /**
   *
   */
  const TABLE = 'package';

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
    'id',
    'from_courier',
    'to_client',
    'to_user',
    'order_service',
    'tracking',
    'large',
    'width',
    'height',
    'weight',
    'value',
    'volumetricweightm',
    'volumetricweighta',
    'type',
    'dettype',
    'category',
    'office',
    'invoice',
    'code',
    'last_event',
    'start_at',
    'consolidated'
  ];

  /**
   * @param $name
   */
  public function setTrackingAttribute($tracking) {
    if (!empty($tracking)) {
      $this->attributes['tracking'] = strtolower($tracking);
    }
  }
  /**
   * Implementa la relación de la clave foranea de la tabla packages (category) con la tabla category (id)
   */
  public function getCategory() {
      return $this->hasOne('App\Models\Admin\Category', 'id', 'category');
  }
  /**
  *
  */
  public function getLastEvent() {
    return $this->hasOne('App\Models\Admin\Event', 'id', 'last_event');
  }
  /**
   * Implementa la relación de la clave foranea de la tabla packages (from_client) con la tabla Client (id)
   */
  public function getClient() {
      return $this->hasOne('App\Models\Admin\Client', 'id', 'from_client');
  }
  /**
   * Implementa la relación de la clave foranea de la tabla packages (from_courier) con la tabla Courier (id)
   */
  public function getCourier() {
      return $this->hasOne('App\Models\Admin\Courier', 'id', 'from_courier');
  }
  /**
   * Implementa la relación de la clave foranea de la tabla packages (to_client) con la tabla Client (id)
   */
  public function getToClient() {
      return $this->hasOne('App\Models\Admin\Client', 'id', 'to_client');
  }
  /**
   * Implementa la relación de la clave foranea de la tabla packages (to_user) con la tabla User (id)
   */
  public function getToUser() {
      return $this->hasOne('App\Models\Admin\User', 'id', 'to_user');
  }
  /**
   * Implementa la relación de la clave foranea de la tabla packages (to_client) con la tabla Client (id)
   */
  public function getType() {
      return $this->hasOne('App\Models\Admin\Packages\Transport', 'id', 'type');
  }
  /**
  *
  */
  public function getOficce() {
    return $this->hasOne('App\Models\Admin\Office', 'id', 'office');
  }
  /**
   *
   */
  public function scopeByStatus($query, $value) {
      return $query->where('last_event', '=', $value);
  }
  /**
  *
  */
  public function scopeByLastEventAndUser($query, $user) {
      return $query->where('last_event', '<', HConstants::EVENT_DELIVERED)->where('to_user', '=', $user);
  }
  /**
   *
   */
  public function scopeByConsolidated($query, $value) {
      return $query->where('consolidated', '=', $value);
  }
  /**
   *
   */
  public function scopeByClient($query, $value)
  {
      if($value instanceof Client) {
        return $query->where('client', '=', $value->id);
      } else if(is_integer($value)) {
        return $query->where('client', '=', $value);
      } else if(is_string($value) && is_numeric($value)) {
        return $query->where('client', '=', intval($value));
      }
      return $query;
  }

  /**
   *
   */
  public function scopeByUser($query, $value) {
    if($value instanceof User) {
      return $query->where('to_user', '=', $value->id);
    } else if(is_integer($value)) {
      return $query->where('to_user', '=', $value);
    } else if(is_string($value) && is_numeric($value)) {
      return $query->where('to_user', '=', intval($value));
    }
    return $query;
  }

  /**
   *
   */
  public function scopeByTracking($query, $value)
  {
      return $query->where('tracking', '=', $value);
  }

  /**
   *
   */
  protected static function boot() {
    parent::boot();
    Package::saved(function(Package $package) {
      if($package->tracking == null || $package->tracking == '') {
        $package->tracking = toBase36($package->id,10);
        $package->save();
      }
      if($package->code == null || $package->code == '') {
        $package->code = "WRH-".str_pad($package->id,5,'0',STR_PAD_LEFT);
        $package->save();
      }
    });
  }
}
