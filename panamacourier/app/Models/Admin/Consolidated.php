<?php

namespace App\Models\Admin;


use App\Models\Model;
use Hash;

class Consolidated  extends Model {

  /**
   *
   */
  const TABLE = 'consolidated';

  /**
   * @var string
   */
  protected $table = self::TABLE;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'id',
    'code',
    'description',
    'observation',
    'status',
    'last_event',
    'office',
    'transport',
    'detailstransport'
  ];

  /**
   *
   */
  protected $with = [];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [];

  /**
   *
   */
  public function toOption() {
    return ['id'=>$this->id, 'text'=>"$this->code $this->description"];
  }

  /**
   * @param $name
   */
  public function setCodeAttribute($code) {
    if (!empty($code)) {
      $this->attributes['code'] = "CON-".str_pad($code,5,'0',STR_PAD_LEFT);
    }
  }

  /**
   * @param $name
   */
  public function setDescriptionAttribute($description) {
    if (!empty($description)) {
      $this->attributes['description'] = strtolower($description);
    }
  }

  /**
   * @param $email
   */
  public function setObservationAttribute($observation) {
    if (!empty($observation)) {
      $this->attributes['observation'] = strtolower($observation);
    }
  }

    public function getLastEvent() {
    return $this->hasOne('App\Models\Admin\Event', 'id', 'last_event');
  }

  /**
   *
   */
  public function scopeById($query, $value)
  {
      return $query->where('id', '=', $value);
  }

  /**
  *
  */

    public function scopeBystatus($query, $value)
  {
      return $query->where('status', '=', $value);
  }




}
