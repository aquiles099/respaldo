<?php

namespace App\Models\Admin;

use App\Models\Model;
use Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
/**
 * User: vchacin
 */
class Ciudad extends Model {

  /**
   *
   */
  public $incrementing = true;

  /**
   *
   */
  const TABLE = 'Ciudades';

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
