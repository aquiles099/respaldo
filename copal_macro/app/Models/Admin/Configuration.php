<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Configuration extends Model
{
  use SoftDeletes;
  /**
   *
   */
  protected $with = [

  ];
  /**
   *
   */
  public $incrementing = true;
  /**
   *
   */
  const TABLE = 'configuration';
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
     'date_dashboard',
     'logo_ics',
     'terms_ics',
     'header_receipt',
     'footer_receipt',
     'header_label',
     'footer_label',
     'header_mail',
     'footer_mail',
     'option_selected_label',
     'name_company',
     'dni_company',
     'country_company',
     'region_company',
     'city_company',
     'email_company'
   ];
}
