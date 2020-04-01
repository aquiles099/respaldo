<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Model;
use DB;

class UserNotifications extends Model {
  /**
   *
   */
  protected $with = [
    'getUser',
    'getEvent'
  ];

  /**
   *
   */
  public $incrementing = true;

  /**
   *
   */
  const TABLE = 'user_notifications';

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
  protected $hidden = [

  ];
  /**
  *
  */
  protected $fillable = [
    'user',
    'event'
  ];
  /**
   *
   */
  public function getUser() {
    return $this->hasOne('App\Models\Admin\User','id','user');
  }
  /**
  *
  */
  public function getEvent() {
    return $this->hasOne('App\Models\Admin\Event','id','event');
  }
  /**
  *
  */
  public function scopeByuser($query, $value) {
    return $query->where('user', '=', $value);
  }
  /**
   * Se genera el codigo
   */
  protected static function boot() {
    parent::boot();
    UserNotifications::creating(function(UserNotifications $user_notifications) {
      if($user_notifications->id == null || $user_notifications->id == '' || $user_notifications->id == -1) {
        $user_notifications->id = DB::select('select seq_user_notifications_func() as id')[0]->id;
      }
      // conversion a hexadecimal
      if($user_notifications->code == null || $user_notifications->code == '') {
        $user_notifications->code = "NFU-".str_pad($user_notifications->id,5,'0',STR_PAD_LEFT);
      }
    });
  }
}
