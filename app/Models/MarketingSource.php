<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

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


  public function workers(): HasMany
  {
    return $this->hasMany(Worker::class);
  }
  public function companies(): HasMany
  {
    return $this->hasMany(Company::class);
  }
}
