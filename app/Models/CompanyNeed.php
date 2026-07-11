<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
  'company_branch_id',
  'required_workers_count',
  'required_profession',
  'needed_at',
  'employment_type',
  'offered_salary',
  'currency',
  'additional_details',
])]
class CompanyNeed extends Model
{

  public function branch(): BelongsTo
  {
    return $this->belongsTo(CompanyBranch::class, 'company_branch_id');
  }
}
