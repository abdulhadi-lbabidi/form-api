<?php

namespace App\Models;

use App\MediaLibrary\KadrPathGenerator;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGeneratorFactory;

#[Fillable([
  'name',
  'first_name',
  'father_name',
  'last_name',
  'date_of_birth',
  'number_of_person',
  'email',
  'phone',
  'password',
  'shop_address',
  'city',
  'residential_area',
  'service_type',
  'has_team',
  'social_or_website_link',
])]
class Kadr extends Authenticatable  implements HasMedia
{
  use HasApiTokens, HasFactory, InteractsWithMedia;

  protected function casts(): array
  {
    return [
      'password' => 'hashed',
      'has_team' => 'boolean',
      'date_of_birth' => 'date',
    ];
  }

  public function marketingSources(): MorphToMany
  {
    return $this->morphToMany(
      MarketingSource::class,
      'marketing_sourceable',
      'marketing_sourceables'
    );
  }

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected static function booting(): void
  {
    PathGeneratorFactory::setCustomPathGenerators(
      static::class,
      KadrPathGenerator::class
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
}
