<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
  'name',
  'amount',
  'created_by',
])]
class Expense extends Model
{
  protected function casts(): array
  {
    return [
      'created_at' => 'datetime',
      'amount' => 'decimal:2',
    ];
  }

  public function creator(): BelongsTo
  {
    return $this->belongsTo(User::class, 'created_by');
  }
}
