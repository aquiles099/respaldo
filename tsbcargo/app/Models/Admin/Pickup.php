<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Helpers\HConstants;

class Pickup extends Model
{
    /**
   *
   */
  protected $with = [
    'getToUser',
    'getType',
    'getCategory',
    'getLastEvent',
    'getOffice'

  ];

  /**
   *
   */
  public $incrementing = true;

  /**
   *
   */
  const TABLE = 'pickup_orders';

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
    'code',
    'from_user',
    'to_user',
    'consigner_user',
    'value',
    'type',
    'details_type',
    'category',
    'office',
    'typeservice',
    'addcharge',
    'promotion',
    'observation',
    'last_event',
    'insurance',
    'volumetricweightm',
    'volumetricweighta',
    'costservice',
    'costinsurance',
    'aditionalcost',
    'subtotal',
    'total',
    'invoice',
    'tax',
    'pro',
    'notes',
    'start_at',
    'booked',
    'process',
    'country_shipper',
    'region_shipper',
    'city_shipper',
    'address_shipper',
    'location_shipper',
    'country_consig',
    'region_consig',
    'city_consig',
    'address_consig',
    'location_consig',
    'provider',
    'po_number',
    'transporter',
    'trans_tracking',
    'pickup_number',
    'pickup_date',
    'deliver_date'
  ];
  /**
   * Implementa la relación de la clave foranea de la tabla packages (category) con la tabla category (id)
   */
  public function getCategory() {
      return $this->hasOne('App\Models\Admin\Category', 'id', 'category');
  }

  public function getLastEvent() {
    return $this->hasOne('App\Models\Admin\PickupStatus', 'id', 'last_event');
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

 public function getOffice() {
    return $this->hasOne('App\Models\Admin\Office', 'id', 'office');
  }
  /**
  *
  */
  public function getCountCargo($value){
    return DB::table('details_pickup_order')->where('pickup', '=', $value)->count();
  }
  /**
  *
  */
  public function scopeByEvent($query, $value){
     return $query->where('last_event', '=', $value);
  }
  /**
  *
  */
  public function scopeByProcessAndEvent($query, $value, $process) {
     return $query->where('last_event', '=', $value)->where('process', '=', $process);
  }
  /**
  * buscar paquetes reservados
  */
  public function scopeByBooked($query, $value) {
    return $query->where('booked', '=', $value)->where('last_event', '=', HConstants::EVENT_RECEIVED);
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
  public function toOption(){
    return ['id' => $this->id, 'text' => $this->code.'|Consignee: '.$this->getToUser->name.' '.$this->getToUser->last_name.'|Packages: '. $this->getCountCargo($this->id)];
  }
  /**
   *
   */
  public function scopeByClient($query, $value){
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
     * Se genera el codigo
     */
  protected static function boot(){
    parent::boot();
    Pickup::creating(function(Pickup $pickup){
      if($pickup->id == null || $pickup->id == '' || $pickup->id == -1) {
        $pickup->id = DB::select('select seq_pickup_orders_func() as id')[0]->id;
      }
      /**
      *
      */
      if($pickup->code == null || $pickup->code == '') {
        $pickup->code = "PKO-".str_pad($pickup->id,5,'0',STR_PAD_LEFT);
      }
      /**
      * asignando fecha en start_at
      */
      if ($pickup != null) {
          $pickup->last_event = HConstants::EVENT_INITIAL;
          $pickup->start_at = date('Y-m-d');
      }
    });
  }



}
