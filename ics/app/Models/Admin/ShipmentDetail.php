<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Model;
use DB;
use App\Helpers\HConstants;
class ShipmentDetail extends Model {
  /**
  *
  */
  protected $with = [
    'getShipment',
    'getPickup',
    'getWareouse'
  ];
  /**
  *
  */
  public $incrementing = true;
  /**
  *
  */
  const TABLE = 'shipment_detail';
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
     'shipment',
     'pickup',
     'warehouse',
     'volume',
     'weight'
  ];
  /**
  * buscar por embarque
  */
   public function scopeByShipment($query, $value) {
      return $query->where('shipment', '=', $value);
   }
   /**
   *
   */
   public function getShipment() {
       return $this->hasOne('App\Models\Admin\Shipment', 'id', 'shipment');
   }
   /**
   *
   */
   public function getPickup() {
      return $this->hasOne('App\Models\Admin\Pickup', 'id', 'pickup');
   }
   /**
   *
   */
   public function getWareouse() {
      return $this->hasOne('App\Models\Admin\Package', 'id', 'warehouse');
   }
   /**
   *
   */
   protected static function boot() {
     parent::boot();
     ShipmentDetail::creating(function(ShipmentDetail $shipment_detail) {
       /**
       * Al guardar almacena el total del peso y el volumen del $shipment_detailwr indicado
       */
       if ($shipment_detail->warehouse != null) {
         $shipment_detail->weight = DB::table('detailspackage')->where('package', '=', $shipment_detail->warehouse)->sum('weight');
         $shipment_detail->volume = DB::table('detailspackage')->where('package', '=', $shipment_detail->warehouse)->sum($shipment_detail->transport == HConstants::TRANSPORT_MARITHIME ? 'volumetricweightm' : $shipment_detail->transport == HConstants::TRANSPORT_AERIAL ? 'volumetricweighta' : 'volumetricweightm');
       }
       /**
       * Al guardar almacena el total del peso y el volumen del pk indicado
       */
       if ($shipment_detail->pickup != null) {
         $shipment_detail->weight = DB::table('details_pickup_order')->where('pickup', '=', $shipment_detail->pickup)->sum('weight');
         $shipment_detail->volume = DB::table('details_pickup_order')->where('pickup', '=', $shipment_detail->pickup)->sum('volumetricweight');
       }
     });
   }
}
