<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Model;
use DB;

class ShipmentRoute extends Model
{
  /**
  *
  */
  protected $with = [
      'getDetailsPort',
      'getVessel'
  ];
  /**
  *
  */
  public $incrementing = true;
  /**
  *
  */
  const TABLE = 'shipment_route';
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
     'service_type',
     'transport_type',
     'route',
     'fly_number',
     'vehicle_number',
     'pro_number',
     'tracking_number',
     'driver_name',
     'licence_number',
     'from_city_departure',
     'date_city_departure',
     'hour_city_departure',
     'from_city_arrived',
     'date_city_arrived',
     'hour_city_arrived',
     'origin_point',
     'pre_transporter',
     'origin_pre_transporter',
     'dock_terminal',
     'port',
     'export_transporter',
     'travel_identifier',
     'vessel',
     'vessel_flag',
     'download_port',
     'deliver_transporter',
     'deliver_city_place'
  ];
  /**
  * buscar por transporte
  */
  public function scopeByRoute($query, $value) {
    return $query->where('route', '=', $value);
  }
  /**
  *
  */
  public function getRoute() {
     return $this->hasOne('App\Models\Admin\Route', 'id', 'route');
  }

  public function getDetailsPort() {
     return $this->hasOne('App\Models\Admin\DetailsTransport', 'id', 'port');
  }

  public function getVessel() {
     return $this->hasOne('App\Models\Admin\Vessel', 'id', 'deliver_city_place');
  }

  public function getCity() {
     return $this->hasOne('App\Models\Admin\City', 'id', 'vessel');
  }
  /**
  * buscar por transporte
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

}
