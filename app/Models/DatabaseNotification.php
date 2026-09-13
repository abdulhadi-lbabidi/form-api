<?php

namespace App\Models;

use Illuminate\Notifications\DatabaseNotification as BaseDatabaseNotification;
use Illuminate\Database\Eloquent\SoftDeletes;

class DatabaseNotification extends BaseDatabaseNotification
{
  use SoftDeletes;

  protected $casts = [
    'data' => 'array',
    'read_at' => 'datetime',
    'deleted_at' => 'datetime',
  ];
}
