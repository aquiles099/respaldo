<?php

namespace App\Models\Admin;

use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Helpers\HConstants;

class Booking extends Model
{
    /**
     *
     */
    protected $with = [
      'getTransport',
      'getFromCountry',
      'getToCountry',
      'getShipper',
      'getConsigneer',
      'getLastEvent'
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
    const TABLE = 'booking';
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
      'code',
      'transport',
      'course',
      'from_country',
      'to_country',
      'since_departure_date',
      'until_departure_date',
      'since_arrived_date',
      'until_arrived_date',
      'declarate_goods',
      'shipper',
      'consigneer',
      'aditional_information',
      'last_event',
      'start_at'
    ];

    /**
     *
     */
    public function getTransport() {
      return $this->hasOne('App\Models\Admin\Transport','id','transport');
    }
    /**
     *
     */
    public function getFromCountry() {
      return $this->hasOne('App\Models\Admin\Country','id','from_country');
    }
    /**
     *
     */
    public function getToCountry() {
      return $this->hasOne('App\Models\Admin\Country','id','to_country');
    }
    /**
     *
     */
    public function getShipper() {
      return $this->hasOne('App\Models\Admin\User','id','shipper');
    }
    /**
     *
     */
    public function getConsigneer() {
      return $this->hasOne('App\Models\Admin\User','id','consigneer');
    }
    /**
    * Obtiene el evento actual
    */
    public function getLastEvent() {
      return $this->hasOne('App\Models\Admin\Event', 'id', 'last_event');
    }
    /**
    *
    */
    public function toOption(){
      return ['code'=>$this->code, 'course'=>"$this->course",'transport'=>"$this->transport"];
    }

    /**
     * Se genera el codigo
     */
    protected static function boot() {
      parent::boot();
      Booking::creating(function(Booking $booking) {
        if($booking->id == null || $booking->id == '' || $booking->id == -1) {
          $booking->id = DB::select('select seq_booking_func() as id')[0]->id;
        }
        /**
        *
        */
        if($booking->code == null || $booking->code == '') {
          $booking->code = "BKG-".toBase36($booking->id);
        }
        /**
        * asignando fecha en start_at
        */
        if ($booking != null) {
          $booking->last_event = HConstants::EVENT_INITIAL;
          $booking->start_at = date('Y-m-d');
        }
      });
    }
}
