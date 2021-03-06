<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Model;
use DB;

class Container extends Model
{
  use SoftDeletes;
  /**
  *
  */
  const TABLE = 'container';
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
      'name',
      'large',
      'width',
      'height',
      'unidad',
      'large_door',
      'widht_door',
      'cube_capacity',
      'max_weight',
      'info'
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
  /**
   * Se genera el codigo
   */
  protected static function boot()
  {
    parent::boot();
    Container::creating(function(Container $container)
    {
      if($container->id == null || $container->id == '' || $container->id == -1)
      {
        $container->id = DB::select('select seq_container_func() as id')[0]->id;
      }
      /**
      * conversion a hexadecimal
      */
      if($container->code == null || $container->code == '')
      {
        $container->code = "CTN-".str_pad($container->id,5,'0',STR_PAD_LEFT);
      }
    });
  }
}
