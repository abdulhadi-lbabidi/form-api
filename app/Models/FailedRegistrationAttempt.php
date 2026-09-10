<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;


#[Fillable([
  'target_type',
  'phone',
  'ip_address',
  'user_agent',
  'payload',
  'platform',
  'browser',
])]
class FailedRegistrationAttempt extends Model
{

  protected $casts = [
    'payload' => 'array',
  ];
}