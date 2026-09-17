<?php

namespace App\Observers;

use App\Models\Currency;
use App\Models\Delegate;
use App\Models\Fund;

class DelegateObserver
{
  /**
   * Handle the Delegate "created" event.
   */
  public function created(Delegate $delegate): void
  {
    $user = $delegate->user;
    $userName = $user ? $user->name : 'مندوب رقم ' . $delegate->id;

    $fund = Fund::create([
      'name' => 'صندوق المندوب: ' . $userName,
      'description' => 'صندوق المالي  للمندوب',
      'user_id' => $user?->id,
    ]);

    $dollarCurrency = Currency::where('symbol', '$')
      ->orWhere('name', 'LIKE', '%دولار أمريكي%')
      ->first();

    if ($dollarCurrency) {
      $fund->currencies()->attach($dollarCurrency->id, [
        'balance' => 0,
        'min_withdrawal_threshold' => 0,
      ]);
    }
  }
  /**
   * Handle the Delegate "updated" event.
   */
  public function updated(Delegate $delegate): void
  {
    //
  }

  /**
   * Handle the Delegate "deleted" event.
   */
  public function deleted(Delegate $delegate): void
  {
    //
  }

  /**
   * Handle the Delegate "restored" event.
   */
  public function restored(Delegate $delegate): void
  {
    //
  }

  /**
   * Handle the Delegate "force deleted" event.
   */
  public function forceDeleted(Delegate $delegate): void
  {
    //
  }
}
