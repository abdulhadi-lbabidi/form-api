<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

#[Fillable([
  'name',
])]
class MarketingSource extends Model
{
  use HasFactory;
  protected function casts(): array
  {
    return [
      'name' => 'array',
    ];
  }

  protected function translatedName(): Attribute
  {
    return Attribute::make(
      get: fn() => $this->name[app()->getLocale()] ?? $this->name['en'] ?? ''
    );
  }


  public function companies(): MorphToMany
  {
    return $this->morphedByMany(
      Company::class,
      'marketing_sourceable',
      'marketing_sourceables'
    );
  }

  public function workers(): MorphToMany
  {
    return $this->morphedByMany(
      Worker::class,
      'marketing_sourceable',
      'marketing_sourceables'
    );
  }
}
