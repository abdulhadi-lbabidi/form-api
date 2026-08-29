<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Kadr\CreateKadrRequest;
use App\Http\Requests\Kadr\UpdateKadrRequst;
use App\Http\Resources\KadrResource;
use App\Models\Kadr;
use App\Service\KadrService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class KadrController extends Controller
{
  public function __construct(
    private KadrService $kadrService
  ) {}

  public function index(Request $request): AnonymousResourceCollection
  {
    $paginate = $request->boolean('paginate', false);
    $perPage  = $request->input('per_page', 10);
    $page     = $request->input('page', 1);

    $kadrs = $this->kadrService->findAll(
      paginate: $paginate,
      perPage: $perPage,
      page: $page
    );

    return KadrResource::collection($kadrs);
  }

  public function store(CreateKadrRequest $request): JsonResponse
  {
    $kadr = $this->kadrService->create($request->validated());

    return response()->json([
      'data'    => new KadrResource($kadr)
    ], 201);
  }

  public function show(Kadr $kadr): KadrResource
  {
    return new KadrResource($kadr);
  }

  public function update(UpdateKadrRequst $request, Kadr $kadr): KadrResource
  {
    $kadrUpdated = $this->kadrService->update($kadr, $request->validated());

    return new KadrResource($kadrUpdated);
  }

  public function destroy(Kadr $kadr): JsonResponse
  {
    $this->kadrService->delete($kadr);

    return response()->json([
      'message' => 'تم حذف الكادر بنجاح'
    ], 200);
  }
}
