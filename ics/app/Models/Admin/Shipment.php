<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Model;
use DB;
use App\Helpers\HConstants;

class Shipment extends Model
{
  /**
  *
  */
  protected $with = [
    'getTransport',
    'getTransporter',
    'getShipper',
    'getEntityToNotify',
    'getCargoAgent',
    'getIntermediary',
    'getDestinyAgent',
    'getConsigner',
    'getLastEvent'
  ];
  /**
  *
  */
  public $incrementing = true;
  /**
  *
  */
  const TABLE = 'shipment';
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
     'name',
     'operator',
     'number_reservation',
     'number_guide',
     'declarate_value',
     'realizate_city_place',
     'realizate_city_date',
     'realizate_city_hour',
     'description',
     'transport',
     'departure_date_mar',
     'departure_hour_mar',
     'arrived_date_mar',
     'arrived_hour_mar',
     'transporter',
     'shipper',
     'from_country',
     'from_airport',
     'to_country',
     'to_airport',
     'containerized',
     'container_name',
     'for_aduana',
     'entity_to_notify',
     'cargo_agent',
     'consigner',
     'intermediary',
     'destiny_agent',
     'last_event',
     'created_at',
     'getOperator',
     'currency',
     'payment',
     'dangerous',
     'agent_charges',
     'transport_charges',
     'tax',
     'insurance',
     'type_payment',
     'type_file',
     'invoice_number',
     'po_number'
  ];
  /**
  * Formateando nombre
  */
  public function setNameAttribute($name) {
     if (!empty($name)) {
        $this->attributes['name'] = strtolower($name);
     }
   }
   /**
   * Formateando descripcion
   */
   public function setDescriptionAttribute($description) {
      if (!empty($description)) {
         $this->attributes['description'] = strtolower($description);
      }
    }
    /**
    *
    */
    public function getOperator() {
        return $this->hasOne('App\Models\Admin\Operator', 'id', 'operator');
    }
    /**
    * Obtiene el evento actual
    */
    public function getLastEvent() {
      return $this->hasOne('App\Models\Admin\ShipmentStatus', 'id', 'last_event');
    }
    /**
    *
    */
    public function getTransport() {
        return $this->hasOne('App\Models\Admin\Transport', 'id', 'transport');
    }
    /**
    *
    */
    public function getTransporter() {
        return $this->hasOne('App\Models\Admin\Transporters', 'id', 'transporter');
    }
    /**
    *
    */
    public function getShipper() {
        return $this->hasOne('App\Models\Admin\User', 'id', 'shipper');
    }
    /**
    *
    */
    public function getEntityToNotify(){
        return $this->hasOne('App\Models\Admin\User', 'id', 'entity_to_notify');
    }
    /**
    *
    */
    public function getCargoAgent(){
        return $this->hasOne('App\Models\Admin\User', 'id', 'cargo_agent');
    }
    /**
    *
    */
    public function getIntermediary(){
        return $this->hasOne('App\Models\Admin\User', 'id', 'intermediary');
    }
    /**
    *
    */
    public function getDestinyAgent(){
        return $this->hasOne('App\Models\Admin\User', 'id', 'intermediary');
    }

    /**
    *
    */
    public function getConsigner() {
        return $this->hasOne('App\Models\Admin\User', 'id', 'consigner');
    }
    /**
     * Se genera el codigo
     */
    protected static function boot()
    {
      parent::boot();
      Shipment::creating(function(Shipment $shipment){
        if($shipment->id == null || $shipment->id == '' || $shipment->id == -1){
          $shipment->id = DB::select('select seq_shipment_func() as id')[0]->id;
        }
         /**
         *
         */
        if($shipment->code == null || $shipment->code == '') {
          $shipment->code = "SHP-".str_pad($shipment->id,5,'0',STR_PAD_LEFT);
        }
        /**
        * asignando fecha en start_at
        */
        if ($shipment != null) {
            $shipment->last_event = HConstants::EVENT_INITIAL;
            $shipment->start_at = date('Y-m-d');
        }
      });
    }
}
