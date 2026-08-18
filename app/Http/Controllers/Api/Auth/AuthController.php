<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\WorkerResource;
use App\Models\Company;
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
    $result = $this->authService->loginUser($request->validated());

    if (!$result) {
      return response()->json([
        'message' => 'بيانات الدخول غير صحيحة',
      ], 401);
    }

    $user = $result['user'];
    $type = $result['type'];

    $userResource = $type === 'company'
      ? new CompanyResource($user)
      : new WorkerResource($user);

    return response()->json([
      'token'     => $result['token'],
      'user_type' => $type,
      'user'      => $userResource
    ]);
  }

  public function me(Request $request)
  {
    $user = $request->user();

    if (!$user) {
      return response()->json(['message' => 'غير مصرح'], 401);
    }

    $type = $user instanceof Company ? 'company' : 'worker';
    $userResource = $type === 'company' ? new CompanyResource($user) : new WorkerResource($user);

    return response()->json([
      'user_type' => $type,
      'user'      => $userResource
    ]);
  }

  public function logout(Request $request)
  {
    $user = $request->user();

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
        'message' => 'حدث خطأ ما، الحساب غير موجود',
      ], 404);
    }

    return response()->json([
      'message' => 'تم تغيير كلمة المرور بنجاح',
    ], 200);
  }
}
