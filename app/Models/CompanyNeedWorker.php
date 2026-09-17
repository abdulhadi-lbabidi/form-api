<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[Fillable([
  'status',
  'company_need_id',
  'delegate_id',
  'worker_id',
])]
class CompanyNeedWorker extends Pivot
{
  protected $table = 'company_need_workers';

  public function delegate(): BelongsTo
  {
    return $this->belongsTo(Delegate::class, 'delegate_id');
  }

  public function worker(): BelongsTo
  {
    return $this->belongsTo(Worker::class, 'worker_id');
  }

  public function companyNeed(): BelongsTo
  {
    return $this->belongsTo(CompanyNeed::class, 'company_need_id');
  }
}
