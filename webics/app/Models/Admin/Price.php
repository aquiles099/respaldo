<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Price extends Model {
  /**
  *
  */
  const TABLE = 'price';
  /**
  *
  */
  protected $table = self::TABLE;
  /**
  *
  */
  protected $with = [

  ];
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'type',
    'years',
    'monthly',
    'annual'
  ];
  /**
  *
  */
  public function scopeByAll ($query, $value1, $value2) {
    return $query->where('type', '=', $value1)->orWhere('type', $value2);
  }
  /**
  *
  */
  public function scopeByType ($query, $value) {
    return $query->where('type', '=', $value);
  }
  /**
  *
  */
  protected static function boot() {
    parent::boot();
    Price::creating(function(Price $price) {
      if($price->id == null || $price->id == '' || $price->id == -1) {
        $price->id = DB::select('select seq_price_func() as id')[0]->id;
      }
      // conversion a hexadecimal
      if($price->code == null || $price->code == '') {
        $price->code   = "PRI-".toBase36($price->id);
      }
    });
  }
}
