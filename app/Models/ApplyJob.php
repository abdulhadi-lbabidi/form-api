<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable([
  'worker_id',
  'jobable_type',
  'jobable_id',
  'status',
  'notes',
])]
class ApplyJob extends Model
{
  use HasFactory;

  protected function casts(): array
  {
    return [
      'created_at' => 'datetime',
      'updated_at' => 'datetime',
    ];
  }

  public function worker(): BelongsTo
  {
    return $this->belongsTo(Worker::class);
  }

  public function jobable(): MorphTo
  {
    return $this->morphTo();
  }
}
