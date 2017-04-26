<?php

namespace App\GitHub;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /** @var string */
    protected $table = 'github_activities';

    /** @var array */
    protected $fillable = [
      'id',
      'json',
      'type',
      'repo_id',
      'repo_name',
      'user_id',
      'user_name',
      'created_at',
    ];
}
