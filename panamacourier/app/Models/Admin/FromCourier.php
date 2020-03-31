<?php

namespace App\Models\Admin;

use App\Models\Model;
use Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Models\Admin\Package;
use App\Models\Admin\Courier;
/**
 * User: vchacin
 */
class FromCourier extends Model {

  /**
   *
   */
  protected $with = [
    'getPackage',
    'getCourier'
  ];

  /**
   *
   */
  public $incrementing = true;

  /**
   *
   */
  const TABLE = 'fromcouriers';

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
    'packageId',
    'courierId',
    'tracking'
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
   * Implementa la relación de la clave foranea de la tabla fromcourier (packageid) con la tabla package (id)
   */
  public function getPackage() {
      return $this->hasOne('App\Models\Admin\Package', 'id', 'packageId');
  }

  /**
   * Implementa la relación de la clave foranea de la tabla fromcourier (courierId) con la tabla Courier (id)
   */
  public function getCourier() {
      return $this->hasOne('App\Models\Admin\Courier', 'id', 'courierId');
  }

  /**
   *
   */
  public function scopeByPackage($query, $value)
  {
      if($value instanceof Package) {
        return $query->where('packageId', '=', $value->id);
      } else if(is_integer($value)) {
        return $query->where('packageId', '=', $value);
      } else if(is_string($value) && is_numeric($value)) {
        return $query->where('packageId', '=', intval($value));
      }
      return $query;
  }

  /**
   *
   */
  public function scopeByCourier($query, $value)
  {
      if($value instanceof Courier) {
        return $query->where('courierId', '=', $value->id);
      } else if(is_integer($value)) {
        return $query->where('courierId', '=', $value);
      } else if(is_string($value) && is_numeric($value)) {
        return $query->where('courierId', '=', intval($value));
      }
      return $query;
  }

}
