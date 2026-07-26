<?php

namespace App\Service;

use Illuminate\Support\Facades\Http;

class TelegramService
{
  public static function send(string $message): void
  {
    try {
      Http::timeout(10)->post(
        "https://api.telegram.org/bot" . config('services.telegram.bot_token') . "/sendMessage",
        [
          'chat_id' => config('services.telegram.chat_id'),
          'text' => $message,
          'parse_mode' => 'HTML'
        ]
      );
    } catch (\Throwable $e) {
    }
  }
}
