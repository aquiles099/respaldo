<?php

namespace App\Models\Admin;

use App\Models\Model;
use Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
/**
 * User: vchacin
 */
class Country extends Model {

  /**
   *
   */
  public $incrementing = true;

  /**
   *
   */
  const TABLE = 'country';

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
    'name'
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
   * Se genera el codigo
   */
  protected static function boot()
  {
    parent::boot();
    Country::creating(function(Country $country)
    {
      if($country->id == null || $country->id == '' || $country->id == -1)
      {
        $country->id = DB::select('select seq_country_func() as id')[0]->id;
      }
      // conversion a hexadecimal
      if($country->code == null || $country->code == '')
      {
        $country->code = "CT-".str_pad($country->id,5,'0',STR_PAD_LEFT);
      }
    });
  }
}
