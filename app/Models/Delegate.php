<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
  'address',
  'user_id',
  'fixed_salary',
  'commission_rate',
  'commission_description',
])]
class Delegate extends Model
{
  use HasFactory;

  protected function casts(): array
  {
    return [
      'fixed_salary' => 'decimal:2',
      'commission_rate' => 'decimal:2',
    ];
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
