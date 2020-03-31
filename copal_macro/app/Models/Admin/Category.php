<?php

namespace App\Models\Admin;


use App\Models\Model;
use Hash;
use DB;

class Category  extends Model {

  /**
   *
   */
  const TABLE = 'category';

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
    'code',
    'label',
    'percentage'
  ];

  /**
   *
   */
  protected $with = [];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [];

  /**
   *
   */
  public function toOption() {
    return ['id'=>$this->id, 'text'=>"$this->label",'percent'=>"$this->percentage"];
  }

  /**
   * @param $name
   */
  public function setLabelAttribute($label) {
    if (!empty($label)) {
      $this->attributes['label'] = strtolower($label);
    }
  }

  /**
   *
   */
  public function scopeById($query, $value)
  {
      return $query->where('id', '=', $value);
  }
  

  /**
   * Se genera el codigo
   */
  protected static function boot()
  {
    parent::boot();
    Category::creating(function(Category $category)
    {
      if($category->id == null || $category->id == '' || $category->id == -1)
      {
        $category->id = DB::select('select seq_category_func() as id')[0]->id;
      }
      // conversion a hexadecimal
      if($category->code == null || $category->code == '')
      {
        $category->code = "CAT-".toBase36($category->id);
      }
    });
  }

}
