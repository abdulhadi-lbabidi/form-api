<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CashbackCategoryResource;
use App\Models\CashbackCategory;
use App\Service\CashbackCategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CashbackCategoryController extends Controller
{
  public function __construct(
    private CashbackCategoryService $cashbackCategoryService
  ) {}

  public function index(Request $request)
  {
    $paginate = $request->boolean('paginate', false);
    $perPage  = $request->input('per_page', 10);
    $page     = $request->input('page', 1);

    $categories = $this->cashbackCategoryService->findAll($paginate, $perPage, $page);

    return CashbackCategoryResource::collection($categories);
  }

  public function show(CashbackCategory $cashbackCategory): JsonResponse
  {
    $categoryData = $this->cashbackCategoryService->findOne($cashbackCategory);

    return response()->json(new CashbackCategoryResource($categoryData));
  }
}
