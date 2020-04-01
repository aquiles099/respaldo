<?php

namespace App\Models\Admin;

use App\Models\Model;
use Crypt;

/**
 * User: jrodriguez
 */
class Operator extends Model {
  /**
   *
   */
  protected $with = [
    'getProfile'
  ];
  /**
   *
   */
  const TABLE = 'operator';
  /**
   * @var string
   */
  protected $table = self::TABLE;
  /**
   * @var bool
   */
  public $timestamps = true;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'code',
    'username',
    'name',
    'lastname',
    'email',
    'password',
    'profile',
    'active',
    'terms',
  ];
  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];
  /**
   * @param $username
   */
  public function setUsernameAttribute($username) {
    if (!empty($username)) {
      $this->attributes['username'] = strtolower($username);
    }
  }
  /**
   * @param $password
   */
  public function setPasswordAttribute($password) {
    if (!empty($password)) {
      $this->attributes['password'] = Crypt::encrypt($password);
    }
  }
  /**
  *
  */
  public function getProfile() {
    return $this->hasOne('App\Models\Admin\Security\Profile', 'id', 'profile');
  }
  /**
   *
   */
  protected static function boot() {
    parent::boot();
    Operator::saved(function(Operator $operator) {
      if($operator->code == null || $operator->code == '') {
        $operator->code = "ADM-".toBase36($operator->id);
        $operator->remember_token = Crypt::encrypt("{$operator->id}/{$operator->email}");
        $operator->save();
      }
    });
  }
  /**
   *
   */
  public function scopeByToken($query, $value) {
    return $query->where('remember_token', '=', $value);
  }
  /**
   * Verifica un password con el password del operador
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

}
