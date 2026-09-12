<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class PreventConcurrentLoginMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  Closure(Request): (Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {

    if (Auth::check()) {
      $user = Auth::user();
      $currentSessionId = session()->getId();

      if (empty($user->session_id)) {
        $user->forceFill(['session_id' => $currentSessionId])->save();
      } elseif ($user->session_id !== $currentSessionId) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        throw ValidationException::withMessages([
          'data.email' => 'عذراً، يوجد مشكلة في عملية تسجيل الدخول.',
        ]);
      }
    }
    return $next($request);
  }
}
