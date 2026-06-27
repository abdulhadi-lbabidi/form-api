<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
  'referralable_id',
  'referralable_type',
  'code',
  'usage_limit',
  'times_used',
  'expires_at',
  'is_active'
])]
class ReferralCode extends Model
{
  public function time(): BelongsTo
  {
    return $this->belongsTo(Time::class);
  }
}
