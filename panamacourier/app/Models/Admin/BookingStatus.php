<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class BookingStatus extends Model
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
  const TABLE = 'booking_status';

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
