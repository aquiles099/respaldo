<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IataCode extends Model
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
  const TABLE = 'iata_codes';

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
    'iata',
    'lon',
    'iso',
    'status',
    'name',
    'continent',
    'type',
    'lat',
    'size'
  ];

  /**
   * @param $name
   */
  public function setIataAttribute($iata) {
    if (!empty($iata)) {
      $this->attributes['iata'] = strtoupper($iata);
    }
  }
}
