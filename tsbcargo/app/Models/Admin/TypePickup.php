<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Hash;


class TypePickup extends Model
{
  use SoftDeletes;
  /**
  *
  */
  const TABLE = 'typepickup';
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
      'description'
  ];
  /**
  *
  */
  public function setNameAttribute($name)
  {
    if (!empty($name))
    {
      $this->attributes['name'] = strtolower($name);
    }
  }

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
    TypePickup::creating(function(TypePickup $typepickup)
    {
      if($typepickup->id == null || $typepickup->id == '' || $typepickup->id == -1)
      {
        $typepickup->id = DB::select('select seq_typepickup_func() as id')[0]->id;
      }
      /**
      * conversion a hexadecimal
      */
      if($typepickup->code == null || $typepickup->code == '')
      {
        $typepickup->code = "TPK-".str_pad($typepickup->id,5,'0',STR_PAD_LEFT);
      }
    });
  }
}
