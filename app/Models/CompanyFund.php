<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable([
  'name',
  'description',
])]
class CompanyFund extends Model
{
  public function currencies(): BelongsToMany
  {
    return $this->belongsToMany(Currency::class, 'company_fund_currencies')
      ->withPivot('balance', 'min_withdrawal_threshold')
      ->withTimestamps();
  }
}
