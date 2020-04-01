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
class Tax extends Model {

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
  const TABLE = 'tax';

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
    'value',
    'type',
    'state',
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
  *
  */

  public function toOption() {
    return ['id'=>$this->id, 'text'=>"$this->name",'tax'=>"$this->value"];
  }

  /**
   * Implementa la relación de la clave foranea de la tabla taxes (country) con la tabla countries (id)
   */
  public function getCountry() {
      return $this->hasOne('App\Models\Admin\Country', 'id', 'country');
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

  public function scopeBystatus($query, $value)
  {
      return $query->where('state', '=', $value);
  }
  /**
   * Se genera el codigo
   */
  protected static function boot()
  {
    parent::boot();
    Tax::creating(function(Tax $tax)
    {
      if($tax->id == null || $tax->id == '' || $tax->id == -1)
      {
        $tax->id = DB::select('select seq_tax_func() as id')[0]->id;
      }
      // conversion a hexadecimal
      if($tax->code == null || $tax->code == '')
      {
        $tax->code = "TAX-".str_pad($tax->id,5,'0',STR_PAD_LEFT);
      }
    });
  }
}
