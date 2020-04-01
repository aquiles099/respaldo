<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class ItemMenu extends Model
{
    protected $table='item_menu';

    protected $fillable = [
      'id',
      'icon',
      'description',
      'path'
    ];
}
