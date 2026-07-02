<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable([
  'time_id',
  'status',
  'note',
  'subscribable_id',
  'subscribable_type',
])]
class Subscription extends Model
{
  public function time(): BelongsTo
  {
    return $this->belongsTo(Time::class);
  }

  public function subscribable(): MorphTo
  {
    return $this->morphTo();
  }
}
