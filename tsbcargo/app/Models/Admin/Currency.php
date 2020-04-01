<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model {

  /**
   *
   */
  public $incrementing = true;

  /**
   *
   */
  const TABLE = 'currency';

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
    'code',
    'name'
  ];
}
