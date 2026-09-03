<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable([
  'kadr_id',
  'stars',
  'reason',
  'feedbackable_type',
  'feedbackable_id',
])]
class KadrFeedback extends Model
{
  use HasFactory;

  protected $table = 'kadr_feedback';

  public function kadr(): BelongsTo
  {
    return $this->belongsTo(Kadr::class);
  }

  public function feedbackable(): MorphTo
  {
    return $this->morphTo();
  }
}
