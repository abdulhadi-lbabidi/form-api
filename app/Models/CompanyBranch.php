<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
  'company_id',
  'branch_name',
  'location_address',
])]
class CompanyBranch extends Model
{
  public function company(): BelongsTo
  {
    return $this->belongsTo(Company::class);
  }

  public function needs(): HasMany
  {
    return $this->hasMany(CompanyNeed::class, 'company_branch_id');
  }
}
