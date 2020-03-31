<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class NumberParts extends Model
{
    use SoftDeletes;
  /**
  *
  */
  const TABLE = 'numberparts';
  /**
  *
  */
  protected $table = self::TABLE;
  /**
  *
  */
  protected $with = [];
  /**
  *
  */
  protected $hidden = [];
  /**
  *
  */
  protected $fillable =
  [
      'code',
      'name',
      'description',
      'model',
      'customer',
      'manufacturer',
      'package',
      'note',
      'large',
      'width',
      'height',
      'weight',
      'volumetricweightm',
      'volumetricweighta',
      'pieces',
      'sku'

  ];
  /**
  *
  */
  public function setDescriptionAttribute($description)
  {
    if (!empty($description))
    {
      $this->attributes['description'] = strtolower($description);
    }
  }
  /**
  *
  */
  /**
   * Se genera el codigo
   */
  protected static function boot()
  {
    parent::boot();
    NumberParts::creating(function(NumberParts $numberparts)
    {
      if($numberparts->id == null || $numberparts->id == '' || $numberparts->id == -1)
      {
        $numberparts->id = DB::select('select seq_numberparts_func() as id')[0]->id;
      }
      /**
      * conversion a hexadecimal
      */
      if($numberparts->code == null || $numberparts->code == '')
      {
        $numberparts->code = "NMP-".toBase36($numberparts->id);
      }
    });
  }
}
