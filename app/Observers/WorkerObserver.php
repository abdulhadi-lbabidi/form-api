<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Worker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class WorkerObserver
{

  /**
   * Handle the Worker "creating" event.
   */
  public function creating(Worker $worker): void
  {
    $worker->full_name = trim("{$worker->first_name} {$worker->father_name} {$worker->last_name}");

    $password = request()->input('password');
    $phone = request()->input('phone_whatsapp') ?? request()->input('phone_number') ?? $worker->phone_whatsapp;
    $workerName = $worker->full_name ?: 'عامل جديد';

    $user = User::create([
      'name'         => $workerName,
      'email'        => null,
      'phone_number' => $phone,
      'password'     => filled($password) ? $password : Hash::make('12345678'),
    ]);

    $worker->user_id = $user->id;
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
    if ($worker->isDirty(['first_name', 'father_name', 'last_name'])) {
      $worker->full_name = trim("{$worker->first_name} {$worker->father_name} {$worker->last_name}");
    }

    if ($worker->user) {
      $dataToUpdate = [];

      $userEmail = request()->input('user_email');
      if (filled($userEmail)) {
        $dataToUpdate['email'] = $userEmail;
      }

      $password = request()->input('password');
      if (filled($password)) {
        $dataToUpdate['password'] = $password;
      }

      $phone = request()->input('phone_whatsapp') ?? request()->input('phone_number');
      if (filled($phone)) {
        $dataToUpdate['phone_number'] = $phone;
      } elseif ($worker->isDirty('phone_whatsapp')) {
        $dataToUpdate['phone_number'] = $worker->phone_whatsapp;
      }

      if (!empty($dataToUpdate)) {
        $worker->user->update($dataToUpdate);
      }
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
