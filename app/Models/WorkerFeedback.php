<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable([
  'worker_id',
  'stars',
  'reason',
  'feedbackable_type',
  'feedbackable_id',
])]
class WorkerFeedback extends Model
{
  use HasFactory;

  public function worker(): BelongsTo
  {
    return $this->belongsTo(Worker::class);
  }

  public function feedbackable(): MorphTo
  {
    return $this->morphTo();
  }
}
