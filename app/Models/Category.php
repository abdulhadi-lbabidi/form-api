<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable([
  'name',
  'description',
])]
class Category extends Model
{
  use HasFactory;

  public function workers(): BelongsToMany
  {
    return $this->belongsToMany(Worker::class, 'category_workers', 'category_id', 'worker_id');
  }

  public function companies(): BelongsToMany
  {
    return $this->belongsToMany(Company::class, 'category_companies', 'category_id', 'company_id');
  }


  public function kadrs(): BelongsToMany
  {
    return $this->belongsToMany(Kadr::class, 'category_kadrs', 'category_id', 'kadr_id');
  }
}
