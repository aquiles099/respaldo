<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class DetailsTransport extends Model
{
    /**
   *
   */
  const TABLE = 'detailstransport';

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
    'name',
    'description',
    'transport'
  ];

  /**
 * Se genera el codigo
 */
protected static function boot() {
  parent::boot();
  DetailsTransport::creating(function(DetailsTransport $details_transport) {

    if($details_transport->id == null || $details_transport->id == '' || $details_transport->id == -1) {
      $details_transport->id = DB::select('select seq_details_transport_func() as id')[0]->id;
    }
     /**
     *
     */
    if($details_transport->code == null || $details_transport->code == '') {
      $details_transport->code = "PRT-".str_pad($details_transport->id,5,'0',STR_PAD_LEFT);
    }
  });
}
}
