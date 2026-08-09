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
}
