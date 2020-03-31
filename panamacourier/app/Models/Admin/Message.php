<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
  protected $fillable = [
    'user',
    'subject',
    'description',
    'email',
    'image'
  ];
}
