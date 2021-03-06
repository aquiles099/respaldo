<?php

namespace App\Models\Admin;

use App\Models\Model;
use Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
/**
 * User: vchacin
 */
class Log extends Model {

  /**
   *
   */
  protected $with = [
    'getEvent',
    'getPreviousEvent',
    'getUser'
  ];

  /**
   *
   */
  public $incrementing = true;

  /**
   *
   */
  const TABLE = 'log';

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
    'package',
    'user',
    'event',
    'previous_event',
    'observation'
  ];

  /**
   * @param $observation
   */
  public function setObservationAttribute($observation) {
    if (!empty($observation)) {
      $this->attributes['observation'] = strtolower($observation);
    }
  }

  /**
   * Implementa la relación de la clave foranea de la tabla log (user) con la tabla User (id)
   */
  public function getUser() {
    return $this->hasOne('App\Models\Admin\User', 'id', 'user');
  }

  /**
   * Implementa la relación de la clave foranea de la tabla log (event) con la tabla Event (id)
   */
  public function getEvent() {
    return $this->hasOne('App\Models\Admin\Event', 'id', 'event');
  }

  /**
   * Implementa la relación de la clave foranea de la tabla log (previous_event) con la tabla Event (id)
   */
  public function getPreviousEvent() {
    return $this->hasOne('App\Models\Admin\Event', 'id', 'previous_event');
  }

  /**
   *
   */
  public function scopeByPackage($query, $value)
  {
      return $query->where('package', '=', $value);
  }

}
