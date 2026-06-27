<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

#[Fillable([
  'company_name',
  'business_type',
  'problems_faced',
  'work_location',
  'email',
  'phone_number',
  'owner_name'
])]
class Company extends Model
{
  public function referralCode(): MorphOne
  {
    return $this->morphOne(ReferralCode::class, 'referralable');
  }
}