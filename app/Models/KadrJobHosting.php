<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[Fillable([
  'kadr_id',
  'title',
  'job_type',
  'workers_count',
  'shift_period',
  'time_from',
  'time_to',
  'city',
  'district',
  'experience_level',
  'salary_min',
  'salary_max',
  'currency',
  'salary_interval',
  'notes',
  'status',
])]
class KadrJobHosting extends Model
{
  use HasFactory;

  protected function casts(): array
  {
    return [
      'created_at' => 'datetime',
      'workers_count' => 'integer',
      'salary_min' => 'decimal:2',
      'salary_max' => 'decimal:2',
    ];
  }

  public function kadr(): BelongsTo
  {
    return $this->belongsTo(Kadr::class);
  }

  public function applyJobs(): MorphMany
  {
    return $this->morphMany(ApplyJob::class, 'jobable');
  }

  public function categories(): BelongsToMany
  {
    return $this->belongsToMany(
      Category::class,
      'category_kadr_job_hostings',
      'kadr_job_hosting_id',
      'category_id'
    );
  }
}
