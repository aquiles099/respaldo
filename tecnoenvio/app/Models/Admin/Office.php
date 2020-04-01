<?php

namespace App\Models\Admin;

use App\Models\Model;
use Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Models\Admin\Country;
/**
 * User: vchacin
 */
class Office extends Model {

  /**
   *
   */
  protected $with = [
    'getCountry'
  ];

  /**
   *
   */
  public $incrementing = true;

  /**
   *
   */
  const TABLE = 'office';

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
    'phone',
    'direction',
    'country'
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
   * @param $direction
   */
  public function setDirectionAttribute($direction) {
    if (!empty($direction)) {
      $this->attributes['direction'] = strtolower($direction);
    }
  }

  /**
   * Implementa la relación de la clave foranea de la tabla offices (country) con la tabla countries (id)
   */
  public function getCountry() {
      return $this->hasOne('App\Models\Admin\Country', 'id', 'country');
  }

    public function toOption() {
      return ['id' => $this->id,'text' => "$this->name"];
    }

  /**
   *
   */
  public function scopeByCountry($query, $value)
  {
      if($value instanceof Country) {
        return $query->where('country', '=', $value->id);
      } else if(is_integer($value)) {
        return $query->where('country', '=', $value);
      } else if(is_string($value) && is_numeric($value)) {
        return $query->where('country', '=', intval($value));
      }
      return $query;
  }
  /**
   * Se genera el codigo
   */
  protected static function boot() {
    parent::boot();
    Office::creating(function(Office $office) {
      if($office->id == null || $office->id == '' || $office->id == -1) {
        $office->id = DB::select('select seq_office_func() as id')[0]->id;
      }
       /**
       *
       */
      if($office->code == null || $office->code == '') {
        $office->code = "OFI-".str_pad($office->id,5,'0',STR_PAD_LEFT);
      }
    });
  }
}
