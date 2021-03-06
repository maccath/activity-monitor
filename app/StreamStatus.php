<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StreamStatus extends Model
{
    protected $table = 'stream_status';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['name', 'last_fetch'];
    protected $primaryKey = 'name';
    protected $casts = [
      'last_fetch' => 'datetime',
    ];
}
