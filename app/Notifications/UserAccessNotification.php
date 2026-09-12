<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Filament\Notifications\Notification as FilamentNotification;

class UserAccessNotification extends Notification implements ShouldQueue
{
  use Queueable;

  protected $user;
  protected $messageText;
  protected $type;

  /**
   * Create a new notification instance.
   */
  public function __construct($user, string $messageText, string $type)
  {
    $this->user = $user;
    $this->messageText = $messageText;
    $this->type = $type;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @return array<int, string>
   */
  public function via(object $notifiable): array
  {
    return ['database', 'broadcast'];
  }

  /**
   * Get the mail representation of the notification.
   */
  public function toDatabase(object $notifiable): array
  {
    return FilamentNotification::make()
      ->title($this->type === 'login' ? 'تسجيل دخول جديد' : 'تسجيل خروج')
      ->body($this->messageText)
      ->icon($this->type === 'login' ? 'heroicon-o-arrow-left-start-on-rectangle' : 'heroicon-o-arrow-right-end-on-rectangle')
      ->iconColor($this->type === 'login' ? 'success' : 'danger')
      ->getDatabaseMessage();
  }
  /**
   * Get the array representation of the notification.
   *
   * @return array<string, mixed>
   */
  public function toArray(object $notifiable): array
  {
    return [
      //
    ];
  }
}
