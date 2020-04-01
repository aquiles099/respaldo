<?php

namespace App\Models\Admin\Packages;

use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * User: jrodriguez
 */
class Transport extends Model {
  use SoftDeletes;

  /**
   *
   */
  const TABLE = 'transport';

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


  public function getName()
  {
    switch(\App::getLocale()){
        case 'es' : return $this->spanish;
        case 'en' : return $this->english;
        default   : return $this->spanish;
    }
  }

  /**
   *
   */
  public function toOption() {
    return ['id' => $this->id, 'text' => $this[$this->getLang()],'price' => "$this->price"];
  }
}
