<?php
namespace App\Models\Admin;
use Crypt;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserType extends Model {
  /**
  *
  */
  use SoftDeletes;
  /**
  *
  */
  const TABLE = 'user_type';
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
