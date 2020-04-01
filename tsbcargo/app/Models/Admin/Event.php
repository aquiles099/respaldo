<?php

namespace App\Models\Admin;

use App\Models\Model;
use Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
/**
 * User: vchacin
 */
class Event extends Model {

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
  const TABLE = 'event';

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
    'description',
    'notification',
    'active',
    'step'
  ];

  /**
   * @param $name
   */
  public function setDescriptionAttribute($description) {
    if (!empty($description)) {
      $this->attributes['description'] = strtolower($description);
    }
  }

}
