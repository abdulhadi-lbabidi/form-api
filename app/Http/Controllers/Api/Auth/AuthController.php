<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Service\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function __construct(
    private AuthService $authService
  ) {}

  public function login(LoginRequest $request)
  {
    $token = $this->authService->loginUser($request->validated());

    if (!$token) {
      return response()->json([
        'message' => 'بيانات الدخول (البريد الإلكتروني/رقم الجوال أو كلمة المرور) غير صحيحة',
      ], 401);
    }

    $user = User::where('email', $request->email)
      ->orWhere('phone_number', $request->phone_number)
      ->first();

    $user->load([
      'worker',
      'company',
    ]);

    return response()->json([
      'token'   => $token,
      'user'    => new UserResource($user)
    ]);
  }

  public function me()
  {
    $user = Auth::user();

    $user->load([
      'worker',
      'company',
    ]);

    return new UserResource($user);
  }

  public function logout()
  {
    /** @var \App\Models\User $user */
    $user = Auth::user();

    if ($user) {
      $user->currentAccessToken()->delete();
    }

    return response()->json([
      'message' => 'تم تسجيل الخروج بنجاح',
    ], 200);
  }
  public function updatePassword(UpdatePasswordRequest $request)
  {
    $updated = $this->authService->updatePassword($request->validated());

    if (!$updated) {
      return response()->json([
        'message' => 'حدث خطأ ما، البريد الإلكتروني غير موجود',
      ], 404);
    }

    return response()->json([
      'message' => 'تم تغيير كلمة المرور بنجاح',
    ], 200);
  }
}
