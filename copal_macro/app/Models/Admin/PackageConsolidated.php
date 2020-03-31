<?php

namespace App\Models\Admin;


use App\Models\Model;
use Hash;

class PackageConsolidated  extends Model {

  /**
   *
   */
  const TABLE = 'package_consolidated';

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
    'package',
    'consolidated',
    'observation'
  ];

  /**
   *
   */
  protected $with = [
    'getPackage',
    'getConsolidated'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [];

  /**
   *
   */
  public function toOption() {
    return ['id'=>$this->id, 'text'=>"$this->package $this->consolidated $this->observation"];
  }

  /**
   * @param $name
   */
  public function setObservationAttribute($observation) {
    if (!empty($observation)) {
      $this->attributes['observation'] = strtolower($observation);
    }
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
  public function getConsolidated() {
      return $this->hasOne('App\Models\Admin\Consolidated', 'id', 'consolidated');
  }

  /**
   *
   */
  public function scopeByPackage($query, $value)
  {
      return $query->where('package', '=', $value);
  }

  /**
   *
   */
  public function scopeByConsolidated($query, $value)
  {
      return $query->where('consolidated', '=', $value);
  }
}
