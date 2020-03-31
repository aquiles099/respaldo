<?php

namespace App\Models\Admin;

use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class BookingDetail extends Model
{
  /**
   *
   */
  protected $with =
  [
    'getBooking',
    'getContainer'
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
  const TABLE = 'booking_detail';
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
  protected $fillable =
  [
    'booking',
    'description',
    'container',
    'pieces',
    'large',
    'width',
    'height',
    'maritime_volume',
    'aerial_volume',
    'weight'
  ];
  /**
   *
   */
  public function getBooking() {
    return $this->hasOne('App\Models\Admin\Booking','id','booking');
  }
  /**
   *
   */
  public function getContainer() {
    return $this->hasOne('App\Models\Admin\Container','id','container');
  }
  /**
  *
  */
  public function scopeByBooking($query, $value) {
    return $query->where('booking', '=', $value);
  }
  /**
  *
  */
}
