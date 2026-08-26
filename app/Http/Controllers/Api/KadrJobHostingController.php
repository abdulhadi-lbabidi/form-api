<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\KadrJobHosting\CreateKadrJobHostingRequest;
use App\Http\Requests\KadrJobHosting\UpdateKadrJobHostingRequest;
use App\Http\Resources\KadrJobHostingResource;
use App\Models\KadrJobHosting;
use App\Service\KadrJobHostingService;
use Illuminate\Http\Request;

class KadrJobHostingController extends Controller
{
  public function __construct(
    private KadrJobHostingService $jobHostingService
  ) {}

  public function index(Request $request)
  {
    $paginate = $request->boolean('paginate', false);
    $perPage  = $request->input('per_page', 10);
    $page     = $request->input('page', 1);

    $jobHostings = $this->jobHostingService->findAll($paginate, $perPage, $page);

    return KadrJobHostingResource::collection($jobHostings);
  }

  public function store(CreateKadrJobHostingRequest $request)
  {
    $validated = $request->validated();
    $jobHosting = $this->jobHostingService->create($validated);
    $jobHosting->load(['kadr']);

    return response()->json([
      'data' => new KadrJobHostingResource($jobHosting)
    ], 201);
  }

  public function show(int $id)
  {
    $jobHosting = $this->jobHostingService->findOne($id);
    return new KadrJobHostingResource($jobHosting);
  }

  public function update(KadrJobHosting $kadrJobHosting, UpdateKadrJobHostingRequest $request)
  {
    $validated = $request->validated();
    $updatedJob = $this->jobHostingService->update($kadrJobHosting, $validated);

    return new KadrJobHostingResource($updatedJob);
  }

  public function destroy(int $id)
  {
    $this->jobHostingService->delete($id);

    return response()->json([
      'message' => 'Kadr Job Hosting deleted successfully'
    ], 200);
  }
}
