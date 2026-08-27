<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Service\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
  public function __construct(
    private CategoryService $categoryService
  ) {}

  public function index(Request $request)
  {
    $paginate = $request->boolean('paginate', false);
    $perPage  = $request->input('per_page', 10);
    $page     = $request->input('page', 1);

    $categories = $this->categoryService->findAll($paginate, $perPage, $page);

    return CategoryResource::collection($categories);
  }
}
