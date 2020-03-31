<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Helpers\HConstants;
class CargoReleaseDetail extends Model {
  /**
   *
   */
  protected $with = [
    'getWarehouseReceipt',
    'getPickupOrder',
    'getCargoRelease'
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
  const TABLE = 'cargo_release_detail';
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
    'cargo_release',
    'type',
    'warehouse_receipt',
    'pickup_order',
    'weight',
    'volume'
  ];
  /**
  *
  */
  public function getWarehouseReceipt() {
    return $this->hasOne('App\Models\Admin\Package', 'id', 'warehouse_receipt');
  }
  /**
  *
  */
  public function getPickupOrder() {
    return $this->hasOne('App\Models\Admin\Pickup', 'id', 'pickup_order');
  }
  /**
  *
  */
  public function getCargoRelease() {
    return $this->hasOne('App\Models\Admin\CargoRelease', 'id', 'CargoRelease');
  }
  /**
  *
  */
  public function scopeByCargoRelease($query, $value) {
    return $query->where('cargo_release', '=', $value);
  }
  /**
  *
  */
  public function getWarehouseReceiptCount($value) {
    return DB::table('detailspackage')->where('package', '=', $value)->count();
  }
  /**
  *
  */
  public function getPickupOrderCount($value) {
    return DB::table('details_pickup_order')->where('pickup', '=', $value)->count();
  }
  /**
  * Se obtienen los totales mientras se va insertando la informacion en la tabla
  */
  protected static function boot() {
    parent::boot();
    CargoReleaseDetail::creating(function(CargoReleaseDetail $cargo_release_detail) {
      /**
      * Al guardar almacena el total del peso y el volumen del wr indicado
      */
      if ($cargo_release_detail->warehouse_receipt != null) {
        $cargo_release_detail->weight = DB::table('detailspackage')->where('package', '=', $cargo_release_detail->warehouse)->sum('weight');
        $cargo_release_detail->volume = DB::table('detailspackage')->where('package', '=', $cargo_release_detail->warehouse)->sum($cargo_release_detail->transport == HConstants::TRANSPORT_MARITHIME ? 'volumetricweightm' : $cargo_release_detail->transport == HConstants::TRANSPORT_AERIAL ? 'volumetricweighta' : 'volumetricweightm');
      }
      /**
      * Al guardar almacena el total del peso y el volumen del pk indicado
      */
      if ($cargo_release_detail->pickup_order != null) {
        $cargo_release_detail->weight = DB::table('details_pickup_order')->where('pickup', '=', $cargo_release_detail->pickup_order)->sum('weight');
        $cargo_release_detail->volume = DB::table('details_pickup_order')->where('pickup', '=', $cargo_release_detail->pickup_order)->sum('volumetricweight');
      }
    });
  }
}
