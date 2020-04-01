<?php

namespace App\Models\Admin;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model {
  /**
  *
  */
  use SoftDeletes;
  /**
  *
  */
  const TABLE = 'status';
  /**
   *
   */
  protected $table = self::TABLE;
  /**
   *
   */
  protected $fillable = [
    'name',
    'description'
  ];
}
