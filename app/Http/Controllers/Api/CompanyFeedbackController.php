<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyFeedbackRequest\CreateCompanyFeedbackRequest;
use App\Http\Requests\CompanyFeedbackRequest\UpdateCompanyFeedbackRequest;
use App\Http\Resources\CompanyFeedbackResource;
use App\Models\CompanyFeedback;
use App\Service\CompanyFeedbackService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompanyFeedbackController extends Controller
{
  public function __construct(
    private CompanyFeedbackService $companyFeedbackService
  ) {}

  public function index(Request $request)
  {
    $paginate = $request->boolean('paginate', false);
    $perPage  = $request->input('per_page', 10);
    $page     = $request->input('page', 1);

    $feedbacks = $this->companyFeedbackService->findAll(
      paginate: $paginate,
      perPage: $perPage,
      page: $page
    );

    return CompanyFeedbackResource::collection($feedbacks);
  }

  public function store(CreateCompanyFeedbackRequest $request): JsonResponse
  {
    $validated = $request->validated();

    $feedback = $this->companyFeedbackService->create($validated);
    $feedback->load(['company', 'feedbackable']);

    return response()->json([
      'data' => new CompanyFeedbackResource($feedback)
    ], 201);
  }

  public function show(int $id): CompanyFeedbackResource
  {
    $feedback = $this->companyFeedbackService->findOne($id);
    return new CompanyFeedbackResource($feedback);
  }

  public function update(UpdateCompanyFeedbackRequest $request, CompanyFeedback $companyFeedback): CompanyFeedbackResource
  {
    $validated = $request->validated();

    $updatedFeedback = $this->companyFeedbackService->update($companyFeedback, $validated);
    $updatedFeedback->load(['company', 'feedbackable']);

    return new CompanyFeedbackResource($updatedFeedback);
  }

  public function destroy(CompanyFeedback $companyFeedback): JsonResponse
  {
    $this->companyFeedbackService->delete($companyFeedback);

    return response()->json([
      'message' => 'تم حذف تقييم الشركة بنجاح'
    ], 200);
  }
}
