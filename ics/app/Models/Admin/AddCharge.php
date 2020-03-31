<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class AddCharge extends Model
{
     use SoftDeletes;
    /**
   *
   */
  const TABLE = 'addcharges';

   /**
   *
   */
  public $incrementing = true;

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
    'id',
    'name',
    'description',
    'value'
  ];

  public function toOption() {
      return ['id' => $this->id, 'text' => "$this->name $this->value",'price' => "$this->value"];
    }
}
