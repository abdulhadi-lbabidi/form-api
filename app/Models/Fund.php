<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[Fillable([
  'name',
  'description',
  'user_id',
])]
class Fund extends Model
{

  protected function casts(): array
  {
    return [
      'created_at' => 'datetime',
    ];
  }
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function expenses(): MorphMany
  {
    return $this->morphMany(Expense::class, 'fundable');
  }


  public function currencies(): BelongsToMany
  {
    return $this->belongsToMany(Currency::class, 'fund_currencies')
      ->withPivot(['balance', 'min_withdrawal_threshold'])
      ->withTimestamps();
  }
}
