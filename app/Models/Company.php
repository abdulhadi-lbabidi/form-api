<?php

namespace App\Models;

use App\MediaLibrary\CompanyPathGenerator;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Str;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGeneratorFactory;

#[Fillable([
  'company_name',
  'business_type',
  'problems_faced',
  'work_location',
  'email',
  'contact_person_name',
  'phone_number',
  'phone_number',
  'owner_name',
  'code',
  'is_verified',
  'form_referral_code',
  'city'
])]
class Company extends Model implements HasMedia
{

  use HasFactory, InteractsWithMedia;
  protected static function booted(): void
  {
    static::created(function (Company $company) {
      $company->referralCode()->create([
        'usage_limit' => 100,
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

  protected static function booting(): void
  {
    PathGeneratorFactory::setCustomPathGenerators(
      static::class,
      CompanyPathGenerator::class
    );
  }

  public function registerMediaConversions(?Media $media = null): void
  {
    $this->addMediaConversion('default')
      ->fit(Fit::Max, 1000, 1000)
      ->quality(70)
      ->format('webp')
      ->nonQueued();
  }


  public function marketingSources(): MorphToMany
  {
    return $this->morphToMany(
      MarketingSource::class,
      'marketing_sourceable',
      'marketing_sourceables'
    );
  }


  public function referralCode(): MorphOne
  {
    return $this->morphOne(ReferralCode::class, 'referralable');
  }
  public function subscriptions(): MorphMany
  {
    return $this->morphMany(Subscription::class, 'subscribable');
  }
}
