<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable([
  'user_id',
  'interviewer_id',
  'booking_date',
  'time_from',
  'status',
  'time_to',
  'notes',
])]
class AdminBooking extends Model
{
  use HasFactory;


  protected $casts = [
    'booking_date' => 'date',
    'time_from' => 'datetime:H:i',
    'time_to' => 'datetime:H:i',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function interviewer(): BelongsTo
  {
    return $this->belongsTo(User::class, 'interviewer_id');
  }

  public function companies(): BelongsToMany
  {
    return $this->belongsToMany(Company::class, 'admin_booking_relations', 'admin_booking_id', 'company_id');
  }

  public function workers(): BelongsToMany
  {
    return $this->belongsToMany(Worker::class, 'admin_booking_relations', 'admin_booking_id', 'worker_id');
  }
}
