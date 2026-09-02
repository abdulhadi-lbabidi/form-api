<?php

namespace App\Models;

use App\MediaLibrary\CompanyPathGenerator;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGeneratorFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable([
  'company_name',
  'business_type',
  'problems_faced',
  'work_location',
  'email',
  'password',
  'contact_person_name',
  'phone_number',
  'owner_name',
  'code',
  'is_verified',
  'form_referral_code',
  'company_status',
  'city',
  'location_id',
])]
class Company extends Authenticatable implements HasMedia
{

  use HasApiTokens, HasFactory, InteractsWithMedia;

  // protected static function booted(): void
  // {

  //   static::creating(function (Company $company) {
  //     $email = request()->input('email') ?? $company->email;
  //     $password = request()->input('password');

  //     if ($email) {
  //       $user = User::create([
  //         'name' => $company->company_name,
  //         'email' => $email,
  //         'password' => $password ? $password : \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(12)),
  //       ]);

  //       $company->user_id = $user->id;
  //     }
  //   });

  //   static::updating(function (Company $company) {
  //     if ($company->user) {
  //       $dataToUpdate = [];
  //       if (request()->has('email') && filled(request()->input('user_email'))) {
  //         $dataToUpdate['email'] = request()->input('user_email');
  //       }
  //       if (request()->has('password') && filled(request()->input('password'))) {
  //         $dataToUpdate['password'] = request()->input('password');
  //       }

  //       if (!empty($dataToUpdate)) {
  //         $company->user->update($dataToUpdate);
  //       }
  //     }
  //   });

  //   static::created(function (Company $company) {
  //     $company->referralCode()->create([
  //       'usage_limit' => 100,
  //       'times_used'  => 0,
  //       'is_active'   => true,
  //       'expires_at'  => null,
  //     ]);

  //     $company->branches()->create([
  //       'branch_name'      => 'أساسي',
  //       'location_address' => null,
  //     ]);
  //   });


  //   static::updating(function (Company $company) {
  //     if ($company->isDirty('is_verified') && $company->is_verified && !$company->code) {
  //       do {
  //         $generatedCode = 'COMP-' . Str::upper(Str::random(10));
  //       } while (static::where('code', $generatedCode)->exists());

  //       $company->code = $generatedCode;
  //     }
  //   });
  // }


  protected function casts(): array
  {
    return [
      'password' => 'hashed',
    ];
  }

  protected $hidden = [
    'password',
    'remember_token',
  ];

  // spatie  media path generator
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

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
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

  public function branches(): HasMany
  {
    return $this->hasMany(CompanyBranch::class);
  }

  public function companyNeeds(): HasMany
  {
    return $this->hasMany(CompanyNeed::class);
  }

  public function categories(): BelongsToMany
  {
    return $this->belongsToMany(Category::class, 'category_companies', 'company_id', 'category_id');
  }

  public function location()
  {
    return $this->belongsTo(Location::class);
  }
}
