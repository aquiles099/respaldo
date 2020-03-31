<?php

namespace App\Models\Admin;


use App\Models\Model;
use App\Models\Admin\Configuration;
use Hash;
use Crypt;
use DB;
class User  extends Model {

  /**
   *
   */
  const TABLE = 'user';

  /**
   * @var string
   */
  protected $table = self::TABLE;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'code',
    'name',
    'email',
    'alt_email',
    'password',
    'user',
    'user_type',
    'last_name',
    'dni',
    'country',
    'region',
    'address',
    'city',
    'postal_code',
    'local_phone',
    'celular',
    'active',
    'sex'
  ];

  /**
   *
   */
  protected $with = [
    'getuser'
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
   *
   */
  public function toOption() {
    return ['id'=>$this->id, 'text'=>"<b>$this->code</b> $this->name $this->email"];
  }

  /**
   * @param $name
   */

  /**
   * @param $name
   */
  public function setNameAttribute($name) {
    if (!empty($name)) {
      $this->attributes['name'] = strtolower($name);
    }
  }

  /**
   * @param $email
   */
  public function setEmailAttribute($email) {
    if (!empty($email)) {
      $this->attributes['email'] = strtolower($email);
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
  public function getuser() {
      return $this->hasOne('App\Models\Admin\user', 'id', 'user');
  }

  /**
   *
   */
  public function scopeByUserType($query, $value) {
      return $query->where('user_type', '=', $value);
  }

  /**
   *
   */
  public function scopeByToken($query, $value) {
    return $query->where('remember_token', '=', $value);
  }

  /**
   * Verifica un password con el password del usuario
   */
  public function checkPassword($password) {
    try {
      if (!empty($password) && is_string($password))
      {
          return ($password == Crypt::decrypt($this->password));
      }
    } catch (\Exception $exception) {

    }
    return false;
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
        $configuration = Configuration::find(1);
        $prefix = (isset($configuration->prefix))&&($configuration->prefix != null)&&($configuration->prefix != '') ? $configuration->prefix : 'USR-';
        $num = 0;
        $num += (isset($configuration->num_ini))&&($configuration->num_ini != null)&&($configuration->num_ini != '') ? $configuration->num_ini : 0;
        $user->code = $prefix.str_pad($user->id+$num,5,'0',STR_PAD_LEFT);
        $user->remember_token = Crypt::encrypt("{$user->id}/{$user->email}");
      }
    });
  }
}
