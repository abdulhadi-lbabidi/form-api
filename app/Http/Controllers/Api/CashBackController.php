<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\CashBackService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CashBackController extends Controller
{
  public function __construct(
    private CashBackService $cashBackService
  ) {}

  public function click(int $id): JsonResponse
  {
    $redirectUrl = $this->cashBackService->incrementClickAndGetUrl($id);

    if (!$redirectUrl) {
      return response()->json(['message' => 'الإعلان غير موجود'], 404);
    }

    return response()->json([
      'redirect_url' => $redirectUrl,
    ]);
  }
}
