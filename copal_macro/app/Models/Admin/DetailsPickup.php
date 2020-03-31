<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

use DB;

class DetailsPickup extends Model {
   /**
   *
   */
  protected $with = [
    'getPickup'
  ];
  /**
  *
  */
  const TABLE = 'details_pickup_order';
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
    'description',
    'type',
    'partnumber',
    'large',
    'width',
    'height',
    'weight',
    'volumetricweight',
    'pieces',
    'value',
    'tracking',
    'invoice',
    'po',
    'pickup',
    'start_at'
  ];
  /**
  *
  */
  public function scopeBypickup($query, $value) {
    return $query->where('pickup', '=', $value);
  }
  /**
  *
  */
  public function getPickup() {
    return $this->hasOne('App\Models\Admin\Pickup', 'id', 'package');
  }
}
