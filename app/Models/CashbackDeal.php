<?php

namespace App\Models;

use App\MediaLibrary\CashbackPathGenerator;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGeneratorFactory;

#[Fillable([
  'cashback_id',
  'start_date',
  'end_date',
  'status',
  'comosion',
  'is_favorite',
  'title',
  'content',
  'redirect_url',
  'images_content',
])]
class CashbackDeal extends Model  implements HasMedia
{
  use HasFactory, InteractsWithMedia;
  protected function casts(): array
  {
    return [
      'created_at' => 'datetime',
      'start_date' => 'date',
      'end_date' => 'date',
      'comosion' => 'decimal:2',
    ];
  }


  protected static function booting(): void
  {
    PathGeneratorFactory::setCustomPathGenerators(
      static::class,
      CashbackPathGenerator::class
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

  public function cashback(): BelongsTo
  {
    return $this->belongsTo(Cashback::class);
  }

  public function counters(): HasMany
  {
    return $this->hasMany(CashbackCounter::class);
  }
}
