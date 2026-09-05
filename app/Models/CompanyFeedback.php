<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable([
  'company_id',
  'stars',
  'reason',
  'feedbackable_type',
  'feedbackable_id',
])]
class CompanyFeedback extends Model
{
  use HasFactory;

  protected $table = 'company_feedback';

  public function company(): BelongsTo
  {
    return $this->belongsTo(Company::class);
  }

  public function feedbackable(): MorphTo
  {
    return $this->morphTo();
  }
}
