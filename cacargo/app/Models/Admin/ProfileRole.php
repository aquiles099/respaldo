<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Model;
use DB;

class ProfileRole extends Model
{
  //
  use SoftDeletes;
  /**
   *
   */
  protected $with = [];
  /**
   *
   */
  public $incrementing = true;
  /**
   *
   */
  const TABLE = 'profile_role';
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
  protected $hidden = [];

   /**
   *
   */
    protected $fillable = [
      'profile',
      'role'
    ];
    /**
    *
    */
}
