<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CashBackResource;
use App\Models\Cashback;
use App\Service\CashBackService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CashBackController extends Controller
{
  public function __construct(
    private CashBackService $cashBackService
  ) {}

  public function index(Request $request)
  {
    $paginate = $request->boolean('paginate', false);
    $perPage  = $request->input('per_page', 10);
    $page     = $request->input('page', 1);

    $cashbacks = $this->cashBackService->findAll($paginate, $perPage, $page);

    return CashBackResource::collection($cashbacks);
  }

  public function show(Cashback $cashback): JsonResponse
  {
    $cashbackData = $this->cashBackService->findOne($cashback);
    return response()->json(new CashBackResource($cashbackData));
  }

  public function click(Cashback $cashback): JsonResponse
  {
    $redirectUrl = $this->cashBackService->incrementClickAndGetUrl($cashback);

    return response()->json([
      'redirect_url' => $redirectUrl,
    ]);
  }
}
