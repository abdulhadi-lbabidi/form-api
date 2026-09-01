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
    $validated = $request->validated();

    $kadr = $this->kadrService->create(
      $validated,
      $request->file('image') ?? []
    );

    $kadr->load(['marketingSources']);

    return response()->json([
      'data'    => new KadrResource($kadr)
    ], 201);
  }

  public function show(int $id): KadrResource
  {
    $kadr = $this->kadrService->findOne($id);
    return new KadrResource($kadr);
  }

  public function update(UpdateKadrRequst $request, Kadr $kadr): KadrResource
  {
    $validated = $request->validated();
    $deletedMediaIds = $request->input('deleted_media_ids', []);


    $kadrUpdated = $this->kadrService->update(
      $kadr,
      $validated,
      $request->file('image'),
      $deletedMediaIds
    );

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
