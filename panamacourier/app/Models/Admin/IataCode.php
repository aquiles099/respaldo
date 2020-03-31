<?php
namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class IataCode extends Model
{
  /**
   *
   */
  protected $with = [

  /**
  * vARIABLES QUE HACEN REFERENCIA AL PERFIEL DE OPERADOR
  */

  ];
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
   * The attributes that are mass assignable.
   *
   * @var array
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
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
  ];
}
