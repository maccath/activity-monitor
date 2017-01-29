<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GithubActivity extends Model
{
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
