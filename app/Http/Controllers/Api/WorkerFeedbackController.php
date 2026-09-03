<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkerFeedback\CreateWorkerFeedbackRequest;
use App\Http\Requests\WorkerFeedback\UpdateWorkerFeedbackRequest;
use App\Http\Resources\WorkerFeedbackResource;
use App\Models\WorkerFeedback;
use App\Service\WorkerFeedbackService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkerFeedbackController extends Controller
{
  public function __construct(
    private WorkerFeedbackService $workerFeedbackService
  ) {}

  public function index(Request $request)
  {
    $paginate = $request->boolean('paginate', false);
    $perPage  = $request->input('per_page', 10);
    $page     = $request->input('page', 1);

    $feedbacks = $this->workerFeedbackService->findAll(
      paginate: $paginate,
      perPage: $perPage,
      page: $page
    );

    return WorkerFeedbackResource::collection($feedbacks);
  }

  public function store(CreateWorkerFeedbackRequest $request): JsonResponse
  {
    $validated = $request->validated();

    $feedback = $this->workerFeedbackService->create($validated);
    $feedback->load(['worker', 'feedbackable']);

    return response()->json([
      'data' => new WorkerFeedbackResource($feedback)
    ], 201);
  }

  public function show(int $id): WorkerFeedbackResource
  {
    $feedback = $this->workerFeedbackService->findOne($id);
    return new WorkerFeedbackResource($feedback);
  }

  public function update(UpdateWorkerFeedbackRequest $request, WorkerFeedback $workerFeedback): WorkerFeedbackResource
  {
    $validated = $request->validated();

    $updatedFeedback = $this->workerFeedbackService->update($workerFeedback, $validated);
    $updatedFeedback->load(['worker', 'feedbackable']);

    return new WorkerFeedbackResource($updatedFeedback);
  }

  public function destroy(WorkerFeedback $workerFeedback): JsonResponse
  {
    $this->workerFeedbackService->delete($workerFeedback);

    return response()->json([
      'message' => 'تم حذف التقييم بنجاح'
    ], 200);
  }
}
