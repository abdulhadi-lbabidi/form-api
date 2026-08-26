<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable([
  'morphable_type',
  'morphable_id',
  'status',
  'notes',
])]
class AccountUpgradeRequest extends Model
{
  use HasFactory;

  protected function casts(): array
  {
    return [
      'created_at' => 'datetime',
    ];
  }

  public function morphable(): MorphTo
  {
    return $this->morphTo();
  }
}
