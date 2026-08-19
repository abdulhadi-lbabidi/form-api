<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[Fillable([
  'status',
  'kadr_need_id',
  'worker_id',
])]
class KadrNeedWorker extends Pivot
{
  protected $table = 'kadr_need_workers';
}
