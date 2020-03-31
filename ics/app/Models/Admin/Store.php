<?php

namespace App\Models\Admin;

use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Store extends Model {
  use SoftDeletes;
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
  const TABLE = 'store';
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
  protected $hidden = [

  ];
  /**
   *
   */
  protected $fillable = [
    'name',
    'description'
  ];
  /**
   * Se genera el codigo
   */
  protected static function boot() {
    parent::boot();
    Store::creating(function(Store $store) {
      if($store->id == null || $store->id == '' || $store->id == -1) {
        $store->id = DB::select('select seq_store_func() as id')[0]->id;
      }
      // conversion a hexadecimal
      if($store->code == null || $store->code == '') {
        $store->code = "STO-".str_pad($store->id,5,'0',STR_PAD_LEFT);
      }
    });
  }
}
