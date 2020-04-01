<?php

namespace App\Models\Admin;

use App\Models\Model;
use Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Models\Admin\Package;
use App\Models\Admin\Company;
/**
 * User: vchacin
 */
class FromCompany extends Model {

  /**
   *
   */
  protected $with = [
    'getPackage',
    'getCompany'
  ];

  /**
   *
   */
  public $incrementing = true;

  /**
   *
   */
  const TABLE = 'fromcompanies';

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
    'companyId',
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
   * Implementa la relación de la clave foranea de la tabla fromcompanies (packageid) con la tabla package (id)
   */
  public function getPackage() {
      return $this->hasOne('App\Models\Admin\Package', 'id', 'packageId');
  }

  /**
   * Implementa la relación de la clave foranea de la tabla fromcompanies (companyId) con la tabla company (id)
   */
  public function getCompany() {
      return $this->hasOne('App\Models\Admin\Company', 'id', 'companyId');
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
  public function scopeByCompany($query, $value)
  {
      if($value instanceof Company) {
        return $query->where('companyId', '=', $value->id);
      } else if(is_integer($value)) {
        return $query->where('companyId', '=', $value);
      } else if(is_string($value) && is_numeric($value)) {
        return $query->where('companyId', '=', intval($value));
      }
      return $query;
  }

}
