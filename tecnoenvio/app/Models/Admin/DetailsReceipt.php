<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class DetailsReceipt extends Model
{
    //
  use SoftDeletes;

  /**
   *
   */
  public $incrementing = true;

  /**
   *
   */
  const TABLE = 'detailsreceipt';

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
      'receipt',
      'type_cost',
      'type_attribute',
      'id_complemento',
      'value_oring',
      'value_package'
   ];

   public function scopeByReceipt($query, $value)
  {
      return $query->where('receipt', '=', $value);
  }
}
