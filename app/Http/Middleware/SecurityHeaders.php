<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
  /**
   * Handle an incoming request.
   *
   * @param  Closure(Request): (Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    $response = $next($request);

    // HSTS (تفعيل الاتصال الآمن إجبارياً لمدة سنة)
    $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');

    // منع تخمين نوع الملفات
    $response->headers->set('X-Content-Type-Options', 'nosniff');

    // الحماية من الهجمات بالتلاعب بالنقرات (Clickjacking)
    $response->headers->set('X-Frame-Options', 'DENY');

    // التحكم في معلومات الـ Referrer
    $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

    // سياسة الصلاحيات (تقييد الكاميرا، الموقع، الميكروفون)
    $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');


    // منع سياسات النطاقات المتقاطعة القديمة (مثل ملفات Flash القديمة)
    $response->headers->set('X-Permitted-Cross-Domain-Policies', 'none');

    // عزل المصادر المتقاطعة (الحماية من ثغرات Spectre وتسريب الذاكرة)
    $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin');
    $response->headers->set('Cross-Origin-Resource-Policy', 'same-origin');

    return $response;
  }
}
