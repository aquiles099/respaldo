<?php

namespace App\Models\Admin;
use Hash;
use Crypt;
use DB;
use \Mail;
use Redirect;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model {
  /**
  *
  */
  use SoftDeletes;
  /**
  *
  */
  const TABLE = 'user';
  /**
   *
   */
  protected $table = self::TABLE;
  /**
   *
   */
  protected $fillable = [
    'code',
    'name',
    'email',
    'password',
    'phone',
    'user_type',
    'remember_token'
  ];
  /**
   *
   */
  protected $with = [
    'getType'
  ];
  /**
   *
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];
  /**
   *
   */
  public function setNameAttribute($name) {
    if (!empty($name)) {
      $this->attributes['name'] = strtolower($name);
    }
  }
  /**
   *
   */
  public function setEmailAttribute($email) {
    if (!empty($email)) {
      $this->attributes['email'] = strtolower($email);
    }
  }
  /**
   *
   */
  public function setPasswordAttribute($password) {
    if (!empty($password)) {
      $this->attributes['password'] = Crypt::encrypt($password);
    }
  }
  /**
   * Verifica un password con el password del usuario
   */
  public function checkPassword($password) {
    try {
      if (!empty($password) && is_string($password)) {
          return ($password == Crypt::decrypt($this->password));
      }
    } catch (\Exception $exception) {
    }
    return false;
  }
  /**
  *
  */
  public function scopeByEmail ($query , $value) {
    return $query->where("email", $value);
  }
  /**
  *
  */
  public function getType() {
    return $this->hasOne('App\Models\Admin\UserType', 'id', 'user_type');
  }
  /**
  *
  */
  public function scopeByType ($query , $value) {
    return $query->where("user_type", $value);
  }
  /**
   * Se genera el codigo
   */
  protected static function boot() {
    parent::boot();
    User::creating(function(User $user) {
      if($user->id == null || $user->id == '' || $user->id == -1) {
        $user->id = DB::select('select seq_user_func() as id')[0]->id;
      }
      // conversion a hexadecimal
      if($user->code == null || $user->code == '') {
        $user->code = "USR-".toBase36($user->id);
        $user->remember_token = Crypt::encrypt("{$user->id}/{$user->email}");
      }
    });
    /**
    *
    */
    User::created(function(User $user) {
      try {
        Mail::send('emails.user.new-user', compact('user') , function($mail) use ($user) {
          $mail->from(env('ICS_MAIL_ADDRESS'));
          $mail->to($user->email, $user->name)
               ->bcc(env('ICS_MAIL_ADDRESS'), $user->name)
               ->subject(strtoupper(trans('mail.created_user')));
        });
      } catch(\Exception $ex) {
          return Redirect::back()->with('errorMessage', $ex->getMessage());
      }
    });
  }
}
