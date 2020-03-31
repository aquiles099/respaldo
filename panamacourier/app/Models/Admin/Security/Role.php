<?php

namespace App\Models\Admin\Security;

use App\Models\Model;
use Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

/**
 * User: jrodriguez
 */
class Role extends Model {
  use SoftDeletes;

  /**
   *
   */
  const TABLE = 'role';

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
  public function access() {
      return $this->belongsToMany('App\Models\Admin\Security\Access', 'role_access', 'role', 'access');
  }

  /**
   *
   */
  public function toOption() {
    return ['id' => $this->id, 'text' => $this->name];
  }
  /**
   * Se genera el codigo
   */
  protected static function boot() {
    parent::boot();
    Role::creating(function(Role $role) {
      if($role->id == null || $role->id == '' || $role->id == -1)
      {
        $role->id = DB::select('select seq_role_func() as id')[0]->id;
      }
      // conversion a hexadecimal
      if($role->code == null || $role->code == '')
      {
        $role->code = "ROL-".toBase36($role->id);
      }
    });
  }
}
