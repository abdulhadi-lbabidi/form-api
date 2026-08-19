<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable([
  'kadr_id',
  'required_workers_count',
  'required_profession',
  'needed_at',
  'employment_type',
  'offered_salary',
  'currency',
  'additional_details',
])]
class KadrNeed extends Model
{
  public function kadr(): BelongsTo
  {
    return $this->belongsTo(Kadr::class, 'kadr_id');
  }

  public function workers(): BelongsToMany
  {
    return $this->belongsToMany(Worker::class, 'kadr_need_workers', 'kadr_need_id', 'worker_id')
      ->using(KadrNeedWorker::class)
      ->withPivot('status')
      ->withTimestamps();
  }
}
