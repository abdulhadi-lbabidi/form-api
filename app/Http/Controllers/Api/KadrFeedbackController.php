<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\KadrFeedbackRequest\CreateKadrFeedbackRequest;
use App\Http\Requests\KadrFeedbackRequest\UpdateKadrFeedbackRequest;
use App\Http\Resources\KadrFeedbackResource;
use App\Models\KadrFeedback;
use App\Service\KadrFeedbackService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KadrFeedbackController extends Controller
{
  public function __construct(
    private KadrFeedbackService $kadrFeedbackService
  ) {}

  public function index(Request $request)
  {
    $paginate = $request->boolean('paginate', false);
    $perPage  = $request->input('per_page', 10);
    $page     = $request->input('page', 1);

    $feedbacks = $this->kadrFeedbackService->findAll(
      paginate: $paginate,
      perPage: $perPage,
      page: $page
    );

    return KadrFeedbackResource::collection($feedbacks);
  }

  public function store(CreateKadrFeedbackRequest $request): JsonResponse
  {
    $validated = $request->validated();

    $feedback = $this->kadrFeedbackService->create($validated);
    $feedback->load(['kadr', 'feedbackable']);

    return response()->json([
      'data' => new KadrFeedbackResource($feedback)
    ], 201);
  }

  public function show(int $id): KadrFeedbackResource
  {
    $feedback = $this->kadrFeedbackService->findOne($id);
    return new KadrFeedbackResource($feedback);
  }

  public function update(UpdateKadrFeedbackRequest $request, KadrFeedback $kadrFeedback): KadrFeedbackResource
  {
    $validated = $request->validated();

    $updatedFeedback = $this->kadrFeedbackService->update($kadrFeedback, $validated);
    $updatedFeedback->load(['kadr', 'feedbackable']);

    return new KadrFeedbackResource($updatedFeedback);
  }

  public function destroy(KadrFeedback $kadrFeedback): JsonResponse
  {
    $this->kadrFeedbackService->delete($kadrFeedback);

    return response()->json([
      'message' => 'تم حذف تقييم الكادر بنجاح'
    ], 200);
  }
}
