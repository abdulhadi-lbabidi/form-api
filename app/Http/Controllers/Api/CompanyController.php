<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CreateCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Service\CompanyService;

class CompanyController extends Controller
{
  public function __construct(
    private CompanyService $companyService
  ) {}

  public function index()
  {
    $companies = $this->companyService->findAll();
    return CompanyResource::collection($companies);
  }

  public function store(CreateCompanyRequest $request)
  {
    $company = $this->companyService->create($request->validated());
    return response()->json([
      'data'    => new CompanyResource($company)
    ], 201);
  }

  public function show(int $id)
  {
    $company = $this->companyService->findOne($id);
    return new CompanyResource($company);
  }

  public function update(UpdateCompanyRequest $request, int $id)
  {
    $company = $this->companyService->update($id, $request->validated());
    return response()->json([
      'data'    => new CompanyResource($company)
    ], 200);
  }

  public function destroy(int $id)
  {
    $this->companyService->delete($id);
    return response()->json([
      'message' => 'Company deleted successfully'
    ], 200);
  }
}
