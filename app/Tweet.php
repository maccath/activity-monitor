<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    /** @var array */
    protected $fillable = [
      'id',
      'json',
      'text',
      'user_id',
      'user_screen_name',
      'created_at',
    ];
}
