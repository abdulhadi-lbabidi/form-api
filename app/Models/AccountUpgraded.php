<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
  'start_date',
  'end_date',
  'comosion',
  'status',
  'account_upgrade_request_id',
])]
class AccountUpgraded extends Model
{
  use HasFactory;

  protected function casts(): array
  {
    return [
      'start_date' => 'date',
      'end_date' => 'date',
      'comosion' => 'decimal:2',
      'created_at' => 'datetime',
    ];
  }

  public function accountUpgradeRequest(): BelongsTo
  {
    return $this->belongsTo(AccountUpgradeRequest::class, 'account_upgrade_request_id');
  }
}
