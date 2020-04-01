<?php

namespace App\Models\Admin;
use Hash;
use Crypt;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\HStatus;

class Client extends Model {
  /**
  *
  */
  use SoftDeletes;
  /**
  *
  */
  const TABLE = 'client';
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
    'admin',
    'dni',
    'country',
    'region',
    'address',
    'city',
    'postal_code',
    'email',
    'password',
    'webpage',
    'sub_domain',
    'status',
    'phone',
    'name_manager',
    'last_name_manager',
    'phone_manager',
    'email_manager',
    'remember_token'
  ];

  /**
   *
   */
  protected $with = [

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
  public function getStatus () {
    return $this->hasOne('App\Models\Admin\Status', 'id', 'status');
  }
  /**
  *
  */
  public function getAdmin () {
    return $this->hasOne('App\Models\Admin\User', 'id', 'admin');
  }
  /**
  *
  */
  public function getCountry () {
    return $this->hasOne('App\Models\Admin\Country', 'id', 'country');
  }
  /**
  *
  */
  public function scopeByRememberToken ($query, $value) {
    return $query->where('remember_token', '=', $value);
  }
  /**
  *
  */
  public function scopeBySlug ($query, $value) {
    return $query->where('slug', '=', $value);
  }
  /**
  *
  */
  public function scopeByUser($query, $value) {
    return $query->where('admin', '=', $value);
  }
  /**
  *
  */
  public function scopeByEmail ($query, $value) {
    return $query->where('email', '=', $value);
  }
  /**
  *
  */
  public function scopeBySubDomain ($query, $value) {
    return $query->where('sub_domain', '=', $value);
  }
  /**
   * Se genera el codigo
   */
  protected static function boot() {
    parent::boot();
    Client::creating(function(Client $client) {
      if($client->id == null || $client->id == '' || $client->id == -1) {
        $client->id = DB::select('select seq_client_func() as id')[0]->id;
      }
      // conversion a hexadecimal
      if($client->code == null || $client->code == '') {
        $client->code = "CLI-".toBase36($client->id);
        $client->slug = str_slug($client->name.$client->code, "-");
        $client->remember_token = Crypt::encrypt("{$client->id}/{$client->email}");
      }
    });
  }
}
