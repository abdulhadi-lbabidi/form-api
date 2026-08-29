<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable([
  'name',
  'number_of_person',
  'email',
  'phone',
  'password',
  'shop_address',
  'city',
])]
class Kadr extends Authenticatable
{
  use HasApiTokens, HasFactory;

  protected function casts(): array
  {
    return [
      'password' => 'hashed',
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
}
