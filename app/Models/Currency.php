<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable([
  'name',
  'symbol',
])]
class Currency extends Model
{

  protected function casts(): array
  {
    return [
      'created_at' => 'datetime',
    ];
  }

  public function funds(): BelongsToMany
  {
    return $this->belongsToMany(Fund::class, 'fund_currencies')
      ->withPivot(['balance', 'min_withdrawal_threshold'])
      ->withTimestamps();
  }

  public function companyFunds(): BelongsToMany
  {
    return $this->belongsToMany(CompanyFund::class, 'company_fund_currencies')
      ->withPivot('balance', 'min_withdrawal_threshold');
  }
}
