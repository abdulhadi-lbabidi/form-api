<?php

namespace App\Models;

use App\MediaLibrary\WorkerPathGenerator;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGeneratorFactory;

#[Fillable([
  'first_name',
  'last_name',
  'father_name',
  'mother_fullname',
  'phone_whatsapp',
  'age',
  'city',
  'residential_area',
  'marital_status',
  'primary_profession',
  'other_professions',
  'work_hours',
  'commitment_level',
  'expected_hourly_rate_usd',
  'expected_hourly_rate_syp',
  'payment_method',
  'code',
  'is_verified',
  'form_referral_code'
])]
class Worker extends Model implements HasMedia
{
  use HasFactory, InteractsWithMedia;

  protected function casts(): array
  {
    return [
      'age' => 'date',
    ];
  }


  protected static function booted(): void
  {
    static::created(function (Worker $worker) {
      $worker->referralCode()->create([
        'usage_limit' => 100,
        'times_used'  => 0,
        'is_active'   => true,
        'expires_at'  => null,
      ]);
    });

    static::updating(function (Worker $company) {
      if ($company->isDirty('is_verified') && $company->is_verified && !$company->code) {

        do {
          $generatedCode = 'Wok-' . Str::upper(Str::random(10));
        } while (static::where('code', $generatedCode)->exists());

        $company->code = $generatedCode;
      }
    });
  }


  protected static function booting(): void
  {
    PathGeneratorFactory::setCustomPathGenerators(
      static::class,
      WorkerPathGenerator::class
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


  public function referralCode(): MorphOne
  {
    return $this->morphOne(ReferralCode::class, 'referralable');
  }

  public function subscriptions(): MorphMany
  {
    return $this->morphMany(Subscription::class, 'subscribable');
  }

  public function ratings(): HasMany
  {
    return $this->hasMany(Rating::class);
  }
}
