<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CashBackDealResource;
use App\Models\CashbackDeal;
use App\Service\CashBackDealService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CashBackDealController extends Controller
{
  public function __construct(
    private CashBackDealService $cashBackDealService
  ) {}

  public function index(Request $request)
  {
    $paginate = $request->boolean('paginate', false);
    $perPage  = $request->input('per_page', 10);
    $page     = $request->input('page', 1);

    $deals = $this->cashBackDealService->findAll($paginate, $perPage, $page);

    return CashBackDealResource::collection($deals);
  }

  public function show(CashbackDeal $cashbackDeal): JsonResponse
  {
    $dealData = $this->cashBackDealService->findOne($cashbackDeal);

    return response()->json(new CashBackDealResource($dealData));
  }
}
