<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Notifications\UserAccessNotification;
use Illuminate\Support\Facades\Notification;

class SendUserAccessNotification
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
  public function handleLogin(Login $event): void
  {

    $user = $event->user;
    $message = "المستخدم {$user->name} قام بتسجيل **الدخول** إلى الموقع.";
    $this->notifyAdmins($user, $message, 'login');
  }

  public function handleLogout(Logout $event): void
  {
    $user = $event?->user;
    if (!$user) {
      return;
    }
    $message = "المستخدم {$user->name} قام بتسجيل **الخروج** من الموقع.";
    $this->notifyAdmins($user, $message, 'logout');
  }

  protected function notifyAdmins($user, string $message, string $type): void
  {
    $admins = User::role(['super_admin'])->get();

    Notification::send($admins, new UserAccessNotification($user, $message, $type));
  }
}