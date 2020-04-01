<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Billing extends Model {
  /**
  *
  */
  use SoftDeletes;
  /**
  *
  */
  protected $with = [

  ];
  /**
  *
  */
  const TABLE = 'billing';
  /**
  *
  */
  protected $table = self::TABLE;
  /**
  *
  */
  protected $fillable = [
    'solicitude',
    'total',
    'debt',
    'next_pay'
  ];
  /**
  *
  */
  public function scopeBySolicitude ($query, $value) {
    return $query->where('solicitude', '=', $value);
  }
  /**
  *
  */
  protected static function boot() {
  parent::boot();
    Billing::creating(function (Billing $billing) {
      if($billing->id == null || $billing->id == '' || $billing->id == -1) {
        $billing->id = DB::select('select seq_billing_func() as id')[0]->id;
      }
      /**
      *
      */
      if($billing->code == null || $billing->code == '') {
        $billing->code   = "BILL-".toBase36($billing->id);
      }
    });
  }
}
