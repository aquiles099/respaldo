<?php

namespace App\Models\Admin;

use App\Models\Model;
use Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Models\Admin\Category;
use App\Models\Admin\Tax;

class TaxCategory extends Model
{
  use SoftDeletes;
  /**
   *
   */
  protected $with = [
    'getCategory',
    'getTax'
  ];

  /**
   *
   */
  public $incrementing = true;

  /**
   *
   */
  const TABLE = 'tax_category';

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
    'category',
    'tax'
  ];

  /**
  * se obtiene la categoria asociada
  */
  public function getCategory()
  {
      return $this->hasOne('App\Models\Admin\Category', 'id', 'category');
  }

  /**
  * se obtiene el impuesto asociado
  */
  public function getTax()
  {
      return $this->hasOne('App\Models\Admin\Tax', 'id', 'tax');
  }

  /**
   * buscamos por categoria
   */
  public function scopeByCategory($query, $value)
  {
      if($value instanceof Category)
      {
        return $query->where('category', '=', $value->id);
      }
      else if(is_integer($value))
      {
        return $query->where('category', '=', $value);
      } else if(is_string($value) && is_numeric($value))
      {
        return $query->where('category', '=', intval($value));
      }
      return $query;
  }

  /**
   * buscamos por impuesto
   */
  public function scopeByTax($query, $value)
  {
      if($value instanceof Tax)
      {
        return $query->where('tax', '=', $value->id);
      }
      else if(is_integer($value))
      {
        return $query->where('tax', '=', $value);
      } else if(is_string($value) && is_numeric($value))
      {
        return $query->where('tax', '=', intval($value));
      }
      return $query;
  }
}
