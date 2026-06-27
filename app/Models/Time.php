<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
  'work_time'
])]
class Time extends Model
{
  public function subscriptions(): HasMany
  {
    return $this->hasMany(Subscription::class);
  }
}
