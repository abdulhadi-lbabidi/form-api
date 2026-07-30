<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

  public function workers(): BelongsToMany
  {
    return $this->belongsToMany(Worker::class, 'company_need_workers', 'company_need_id', 'worker_id');
  }
}
