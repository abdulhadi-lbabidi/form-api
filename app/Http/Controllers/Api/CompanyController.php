<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CreateCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Service\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
  public function __construct(
    private CompanyService $companyService
  ) {}

  public function index(Request $request)
  {
    $paginate = $request->boolean('paginate', false);
    $perPage  = $request->input('per_page', 10);
    $page     = $request->input('page', 1);

    $companies = $this->companyService->findAll($paginate, $perPage, $page);

    return CompanyResource::collection($companies);
  }
  public function store(CreateCompanyRequest $request)
  {
    $validated = $request->validated();
    $company = $this->companyService->create(
      $validated,
      $request->file('image') ?? []
    );
    $company->load(['referralCode', 'marketingSources']);
    return response()->json([
      'data'    => new CompanyResource($company)
    ], 201);
  }

  public function show(int $id)
  {
    $company = $this->companyService->findOne($id);
    return new CompanyResource($company);
  }


  public function update(Company $company, UpdateCompanyRequest $request)
  {
    $validated = $request->validated();
    $newCategory = $this->companyService->update(
      $company,
      $validated,
      $request->file('image')
    );
    return new CompanyResource($newCategory);
  }



  public function destroy(int $id)
  {
    $this->companyService->delete($id);
    return response()->json([
      'message' => 'Company deleted successfully'
    ], 200);
  }
}
