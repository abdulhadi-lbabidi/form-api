<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
  'time_id',
  'status',
  'note'
])]
class Subscription extends Model
{
  public function time(): BelongsTo
  {
    return $this->belongsTo(Time::class);
  }
}