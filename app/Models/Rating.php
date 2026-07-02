<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
  use HasFactory;

  protected $fillable = [
    'worker_id',
    'user_id',
    'seriousness_level',
    'skill_level',
    'communication_level',
    'red_flag',
    'skill_matching',
    'notes',
    'is_verified',
    'verification_notes',
  ];


  public function worker(): BelongsTo
  {
    return $this->belongsTo(Worker::class);
  }


  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
