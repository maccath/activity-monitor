<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StreamStatus extends Model
{
    protected $table = 'stream_status';
    public $timestamps = false;
    protected $fillable = ['name', 'last_fetch'];
    protected $casts = [
      'last_fetch' => 'datetime',
    ];
}
