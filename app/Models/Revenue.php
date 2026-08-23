<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
  'name',
  'amount',
  'description',
  'fundable_type',
  'fundable_id',
  'currency_id',
  'created_by',
])]
class Revenue extends Model
{
  protected function casts(): array
  {
    return [
      'created_at' => 'datetime',
      'amount' => 'decimal:2',
    ];
  }

  public function fundable(): MorphTo
  {
    return $this->morphTo();
  }

  public function currency(): BelongsTo
  {
    return $this->belongsTo(Currency::class, 'currency_id');
  }

  public function creator(): BelongsTo
  {
    return $this->belongsTo(User::class, 'created_by');
  }
}
