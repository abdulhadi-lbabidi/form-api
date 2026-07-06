<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MarketingResource\CreateMarketingSourceRequest;
use App\Http\Requests\MarketingResource\UpdateMarketingSourceRequest;
use App\Http\Resources\MarketingSourceResource;
use App\Service\MarketingSourceService;

class MarketingSourceController extends Controller
{
  public function __construct(
    private MarketingSourceService $marketingSourceService
  ) {}


  public function index()
  {
    $marketingResources = $this->marketingSourceService->findAll();
    return MarketingSourceResource::collection($marketingResources);
  }


  public function store(CreateMarketingSourceRequest $request)
  {
    $marketingResources = $this->marketingSourceService->create($request->validated());
    return response()->json([
      'data'    => new MarketingSourceResource($marketingResources)
    ], 201);
  }


  public function show(int $id)
  {
    $marketingResource = $this->marketingSourceService->findOne($id);
    return new MarketingSourceResource($marketingResource);
  }


  public function update(UpdateMarketingSourceRequest $request, int $id)
  {
    $marketingResource = $this->marketingSourceService->update($id, $request->validated());
    return response()->json([
      'data'    => new MarketingSourceResource($marketingResource)
    ], 200);
  }


  public function destroy(int $id)
  {
    $this->marketingSourceService->delete($id);
    return response()->json([
      'message' => 'marketingResource deleted successfully'
    ], 200);
  }
}
