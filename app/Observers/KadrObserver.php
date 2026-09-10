<?php

namespace App\Observers;

use App\Models\Kadr;
use Illuminate\Support\Str;

class KadrObserver
{
  /**
   * Handle the Kadr "created" event.
   */
  public function created(Kadr $kadr): void
  {
    //
  }


  public function updating(Kadr $kadr): void
  {

    if ($kadr->isDirty('is_verified') && $kadr->is_verified && !$kadr->code) {
      do {
        $generatedCode = 'KADR-' . Str::upper(Str::random(10));
      } while (Kadr::where('code', $generatedCode)->exists());

      $kadr->code = $generatedCode;
    }
  }


  /**
   * Handle the Kadr "updated" event.
   */
  public function updated(Kadr $kadr): void
  {
    //
  }

  /**
   * Handle the Kadr "deleted" event.
   */
  public function deleted(Kadr $kadr): void
  {
    //
  }

  /**
   * Handle the Kadr "restored" event.
   */
  public function restored(Kadr $kadr): void
  {
    //
  }

  /**
   * Handle the Kadr "force deleted" event.
   */
  public function forceDeleted(Kadr $kadr): void
  {
    //
  }
}
