<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Detailspackage extends Model
{
  /**
   *
   */
  protected $with = [
    'getPackage'
  ];
  /**
  *
  */
  const TABLE = 'detailspackage';

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
    'description',
    'large',
    'width',
    'height',
    'weight',
    'transport',
    'order_service',
    'courier',
    'volumetricweightm',
    'volumetricweighta',
    'pieces',
    'value',
    'addcharge',
    'package',
    'route'
  ];
  /**
  *
  */
  public function scopeBypackage($query, $value)
  {
      return $query->where('package', '=', $value);
  }
  /**
  *
  */
  public function getPackage()
  {
    return $this->hasOne('App\Models\Admin\Package', 'id', 'package');
  }
}
