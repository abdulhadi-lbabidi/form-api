<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable([
  'cashback_deal_id',
  'counterable_type',
  'counterable_id',
])]
class CashbackCounter extends Model
{
  protected function casts(): array
  {
    return [
      'created_at' => 'datetime',
    ];
  }

  public function cashbackDeal(): BelongsTo
  {
    return $this->belongsTo(CashbackDeal::class);
  }

  public function counterable(): MorphTo
  {
    return $this->morphTo();
  }
}
