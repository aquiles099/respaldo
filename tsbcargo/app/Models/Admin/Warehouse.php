<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
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
  const TABLE = 'warehouses';
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
     'warehouse',
     'pickup'
   
  ];
}
