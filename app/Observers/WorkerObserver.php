<?php

namespace App\Observers;

use App\Models\Worker;
use Illuminate\Support\Str;

class WorkerObserver
{

  /**
   * Handle the Worker "creating" event.
   */
  public function creating(Worker $worker): void
  {
    if (auth()->check()) {
      $worker->created_by = auth()->id();
    }

    $worker->full_name = trim("{$worker->first_name} {$worker->father_name} {$worker->last_name}");

    if (empty($worker->password)) {
      $worker->password = '12345678'; 
    }
  }


  /**
   * Handle the Worker "created" event.
   */
  public function created(Worker $worker): void
  {
    $worker->referralCode()->create([
      'usage_limit' => 100,
      'times_used'  => 0,
      'is_active'   => true,
      'expires_at'  => null,
    ]);
  }

  /**
   * Handle the Worker "updating" event.
   */
  public function updating(Worker $worker): void
  {

    if (auth()->check()) {
      $worker->updated_by = auth()->id();
    }

    if ($worker->isDirty(['first_name', 'father_name', 'last_name'])) {
      $worker->full_name = trim("{$worker->first_name} {$worker->father_name} {$worker->last_name}");
    }


    if ($worker->isDirty('is_verified') && $worker->is_verified && !$worker->code) {
      do {
        $generatedCode = 'Wok-' . Str::upper(Str::random(10));
      } while (Worker::where('code', $generatedCode)->exists());

      $worker->code = $generatedCode;
    }
  }

  /**
   * Handle the Worker "updated" event.
   */
  public function updated(Worker $worker): void
  {
    //
  }

  /**
   * Handle the Worker "deleted" event.
   */
  public function deleted(Worker $worker): void
  {
    //
  }

  /**
   * Handle the Worker "restored" event.
   */
  public function restored(Worker $worker): void
  {
    //
  }

  /**
   * Handle the Worker "force deleted" event.
   */
  public function forceDeleted(Worker $worker): void
  {
    //
  }
}