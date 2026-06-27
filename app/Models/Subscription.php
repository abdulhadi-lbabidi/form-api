<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
  'time_id',
  'status',
  'note'

])]
class Subscription extends Model
{
  //
}