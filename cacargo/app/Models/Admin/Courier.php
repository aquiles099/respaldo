<?php

namespace App\Models\Admin;

use App\Models\Model;
use Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
/**
 * User: vchacin
 */
class Courier extends Model {

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
  const TABLE = 'courier';

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
    'name',
    'status'
  ];

  /**
   * @param $name
   */
  public function setNameAttribute($name) {
    if (!empty($name)) {
      $this->attributes['name'] = strtolower($name);
    }
  }

  /**
   *
   */
  public function scopeByStatus($query, $value = 1)
  {
        return $query->where('status', '=', $value);
  }
  /**
   * Se genera el codigo
   */
  protected static function boot()
  {
    parent::boot();
    Courier::creating(function(Courier $courier)
    {
      if($courier->id == null || $courier->id == '' || $courier->id == -1)
      {
        $courier->id = DB::select('select seq_courier_func() as id')[0]->id;
      }
      // conversion a hexadecimal
      if($courier->code == null || $courier->code == '')
      {
        $courier->code = "COU-".str_pad($courier->id,5,'0',STR_PAD_LEFT);
      }
    });
  }
}
