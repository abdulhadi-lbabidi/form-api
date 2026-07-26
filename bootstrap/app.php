<?php

use App\Http\Middleware\SetLocalMiddleware;
use App\Service\TelegramService;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    web: __DIR__ . '/../routes/web.php',
    api: __DIR__ . '/../routes/api.php',
    commands: __DIR__ . '/../routes/console.php',
    health: '/up',
  )
  ->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
      'setLocale' => SetLocalMiddleware::class,

    ]);
  })
  ->withExceptions(function (Exceptions $exceptions): void {
    $exceptions->shouldRenderJsonWhen(
      fn(Request $request) => $request->is('api/*'),
    );

    $exceptions->report(function (Throwable $e) {

      if (!app()->isProduction()) {
        return;
      }

      $user = Auth::user();

      $message =
        "🚨 <b>Laravel Exception</b>\n\n" .
        "📝 <b>Message:</b> {$e->getMessage()}\n" .
        "📂 <b>File:</b> {$e->getFile()}\n" .
        "📍 <b>Line:</b> {$e->getLine()}\n\n" .
        "🌐 <b>URL:</b> " . request()->fullUrl() . "\n" .
        "🌍 <b>IP:</b> " . request()->ip() . "\n" .
        "👤 <b>User:</b> " . ($user?->id ?? 'Guest');

      TelegramService::send($message);
    });
  })->create();
