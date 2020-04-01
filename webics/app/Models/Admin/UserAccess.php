<?php

namespace App\Models\Admin;
use DB;

use Illuminate\Database\Eloquent\Model;

class UserAccess extends Model {
  /**
  *
  */
  const TABLE = 'user_access';
  /**
  *
  */
  protected $table = self::TABLE;
  /**
  *
  */
  protected $fillable = [
    'id',
    'item',
    'user'
  ];
  /**
  *
  */
  public function scopeByUser ($query, $value) {
      return $query->where('user', '=', $value);
  }
  /**
  *
  */
  public function getItem () {
    return $this->hasOne('App\Models\Admin\ItemMenu', 'id', 'item');
  }
  /**
  *
  */
}
