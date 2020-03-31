<?php

namespace App\Models\Admin\Security;

use App\Models\Model;
use Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

/**
 * User: jrodriguez
 */
class Profile extends Model {
  use SoftDeletes;

  /**
   *
   */
  const TABLE = 'profile';

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
    'name'
  ];

  /**
   * @var array
   */
  protected $hidden = [

  ];
  /**
   * @param $name
   */
  public function setNameAttribute($name) {
    if (!empty($name)) {
      $this->attributes['name'] = strtolower($name);
    }
  }
  /**
   *
   */
  public function roles() {
      return $this->belongsToMany('App\Models\Admin\Security\Role', 'profile_role', 'profile', 'role');
  }
  /**
   * Se genera el codigo
   */
  protected static function boot() {
    parent::boot();
    Profile::creating(function(Profile $profile) {
      if($profile->id == null || $profile->id == '' || $profile->id == -1)
      {
        $profile->id = DB::select('select seq_profile_func() as id')[0]->id;
      }
      // conversion a hexadecimal
      if($profile->code == null || $profile->code == '')
      {
        $profile->code = "PRF-".toBase36($profile->id);
      }
    });
  }
}
