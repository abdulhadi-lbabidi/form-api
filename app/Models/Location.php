<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
  'name',
  'coordinates',
])]
class Location extends Model
{
  use HasFactory;

  protected function casts(): array
  {
    return [
      'coordinates' => 'array',
    ];
  }

  public function workers()
  {
    return $this->hasMany(Worker::class);
  }

  public function companies()
  {
    return $this->hasMany(Company::class);
  }

  public function kadrs()
  {
    return $this->hasMany(Kadr::class);
  }
}
