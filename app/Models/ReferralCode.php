<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

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

  protected static function booted(): void
  {
    static::creating(function (ReferralCode $referralCode) {
      if (empty($referralCode->code)) {
        $referralCode->code = static::generateUniqueCode();
      }
    });
  }


  private static function generateUniqueCode(): string
  {
    do {
      $code = 'REF-' . strtoupper(Str::random(12));
    } while (static::where('code', $code)->exists());

    return $code;
  }


  public function referralable(): MorphTo
  {
    return $this->morphTo();
  }
}
