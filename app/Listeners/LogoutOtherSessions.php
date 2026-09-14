<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LogoutOtherSessions
{
  /**
   * Create the event listener.
   */
  public function __construct()
  {
    //
  }

  /**
   * Handle the event.
   */

  public function handle(Login $event): void
  {
    DB::table('sessions')
      ->where('user_id', $event->user->getAuthIdentifier())
      ->where('id', '!=', Session::getId())
      ->delete();
  }
}
