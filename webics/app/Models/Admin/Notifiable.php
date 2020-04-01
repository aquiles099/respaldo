<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Http\Request;

class Notifiable extends Model {
  protected $with = [

  ];
  /**
  *
  */
  const TABLE = 'notifiable';
  /**
  *
  */
  protected $table = self::TABLE;
  /**
  *
  */
  protected $fillable = [
    'status',
    'admin'
  ];
  /**
  *
  */
  public function scopeByUser ($query, $value) {
    return $this->where('admin', '=', $value);
  }
}
