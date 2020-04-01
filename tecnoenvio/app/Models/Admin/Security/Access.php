<?php

namespace App\Models\Admin\Security;

use App\Models\Model;
use Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

/**
 * access: jrodriguez
 */
class Access extends Model {
  use SoftDeletes;

  /**
   *
   */
  const TABLE = 'access';

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
    'code',
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
  public function toOption() {
    return ['id' => $this->id, 'text' => $this->name];
  }
  /**
   * Se genera el codigo
   */
  protected static function boot() {
    parent::boot();
    Access::creating(function(Access $access) {
      if($access->id == null || $access->id == '' || $access->id == -1)
      {
        $access->id = DB::select('select seq_access_func() as id')[0]->id;
      }
      // conversion a hexadecimal
      if($access->code == null || $access->code == '')
      {
        $access->code = "PRM-".toBase36($access->id);
      }
    });
  }
}
