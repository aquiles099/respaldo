<?php

namespace App\Models\Admin\Security;

use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * User: jrodriguez
 */
class UserType extends Model {
  use SoftDeletes;

  /**
   *
   */
  const TABLE = 'user_type';

  /**
   * @var string
   */
  protected $table = self::TABLE;

  /**
   * @var bool
   */
  public $timestamps = true;

  /**
   *
   */
  protected $fillable = [
    'spanish',
    'english'
  ];

  /**
   * @var array
   */
  protected $hidden = [

  ];

  /**
   * @param $name
   */
  public function setSpanishAttribute($value) {
    if (!empty($value)) {
      $this->attributes['spanish'] = strtolower($value);
    }
  }

  /**
   * @param $name
   */
  public function setEnglishAttribute($value) {
    if (!empty($value)) {
      $this->attributes['english'] = strtolower($value);
    }
  }

  /**
   *
   */
  public function toOption() {
    return ['id' => $this->id, 'text' => $this[$this->getLang()]];
  }
}
