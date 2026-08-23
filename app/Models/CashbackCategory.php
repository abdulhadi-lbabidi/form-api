<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable([
  'name',
  'description',
])]
class CashbackCategory extends Model
{
  protected function casts(): array
  {
    return [
      'created_at' => 'datetime',
    ];
  }

  public function cashbacks(): BelongsToMany
  {
    return $this->belongsToMany(Cashback::class, 'cashback_cashback_categories')
      ->withTimestamps();
  }
}
