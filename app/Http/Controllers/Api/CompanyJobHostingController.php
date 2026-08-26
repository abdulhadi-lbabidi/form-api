<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyJobHosting\CreateCompanyJobHostingRequest;
use App\Http\Requests\CompanyJobHosting\UpdateCompanyJobHostingRequest;
use App\Http\Resources\CompanyJobHostingResource;
use App\Models\CompanyJobHosting;
use App\Service\CompanyJobHostingService;
use Illuminate\Http\Request;

class CompanyJobHostingController extends Controller
{
  public function __construct(
    private CompanyJobHostingService $jobHostingService
  ) {}

  public function index(Request $request)
  {
    $paginate = $request->boolean('paginate', false);
    $perPage  = $request->input('per_page', 10);
    $page     = $request->input('page', 1);

    $jobHostings = $this->jobHostingService->findAll($paginate, $perPage, $page);

    return CompanyJobHostingResource::collection($jobHostings);
  }

  public function store(CreateCompanyJobHostingRequest $request)
  {
    $validated = $request->validated();
    $jobHosting = $this->jobHostingService->create($validated);
    $jobHosting->load(['company']);

    return response()->json([
      'data' => new CompanyJobHostingResource($jobHosting)
    ], 201);
  }

  public function show(int $id)
  {
    $jobHosting = $this->jobHostingService->findOne($id);
    return new CompanyJobHostingResource($jobHosting);
  }

  public function update(CompanyJobHosting $companyJobHosting, UpdateCompanyJobHostingRequest $request)
  {
    $validated = $request->validated();
    $updatedJob = $this->jobHostingService->update($companyJobHosting, $validated);

    return new CompanyJobHostingResource($updatedJob);
  }

  public function destroy(int $id)
  {
    $this->jobHostingService->delete($id);

    return response()->json([
      'message' => 'Company Job Hosting deleted successfully'
    ], 200);
  }
}
