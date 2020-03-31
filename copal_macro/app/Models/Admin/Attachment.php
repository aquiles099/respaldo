<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Model;
use DB;

class Attachment extends Model
{
  /**
  *
  */
  protected $with = [

  ];
  /**
  *
  */
  public $incrementing = true;
  /**
  *
  */
  const TABLE = 'attachment';
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
    'booking',
    'warehouse',
    'pickup',
    'cargo_release',
    'transporters',
    'suppliers',
    'path',
    'name_path',
    'operator'
  ];
  /**
  *
  */
  public function scopeByBooking($query, $value) {
    return $query->where('booking', '=', $value);
  }
  /**
  * Se genera el codigo
  */
  protected static function boot() {
    parent::boot();
    Attachment::creating(function(Attachment $attachment){
      if($attachment->id == null || $attachment->id == '' || $attachment->id == -1){
        $attachment->id = DB::select('select seq_attachment_func() as id')[0]->id;
      }
      /**
      *
      */
      if($attachment->code == null || $attachment->code == '') {
        $attachment->code = "ATT-".toBase36($attachment->id);
      }
    });
  }
}
