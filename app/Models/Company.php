<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;

#[Fillable([
  'company_name',
  'business_type',
  'problems_faced',
  'work_location',
  'email',
  'phone_number',
  'owner_name',
  'code',
  'is_verified',
])]
class Company extends Model
{


  protected static function booted(): void
  {
    static::created(function (Company $company) {
      $company->referralCode()->create([
        'usage_limit' => 10,
        'times_used'  => 0,
        'is_active'   => true,
        'expires_at'  => null,
      ]);
    });


    static::updating(function (Company $company) {
      if ($company->isDirty('is_verified') && $company->is_verified && !$company->code) {

        do {
          $generatedCode = 'COMP-' . Str::upper(Str::random(10));
        } while (static::where('code', $generatedCode)->exists());

        $company->code = $generatedCode;
      }
    });
  }

  public function referralCode(): MorphOne
  {
    return $this->morphOne(ReferralCode::class, 'referralable');
  }
}
