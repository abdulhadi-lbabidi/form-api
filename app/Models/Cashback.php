<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable([
  'company_name',
  'owner_name',
  'phone_number',
  'reasone',
  'cashbackable_type',
  'cashbackable_id',
])]
class Cashback extends Model
{

  protected function casts(): array
  {
    return [
      'created_at' => 'datetime',
    ];
  }
  public function cashbackable(): MorphTo
  {
    return $this->morphTo();
  }

  public function categories(): BelongsToMany
  {
    return $this->belongsToMany(CashbackCategory::class, 'cashback_cashback_categories')
      ->withTimestamps();
  }
}
