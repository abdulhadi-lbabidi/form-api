<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplyJob\CreateApplyJobRequest;
use App\Http\Resources\ApplyJobResource;
use App\Service\ApplyJobService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApplyJobController extends Controller
{
  public function __construct(
    private ApplyJobService $applyJobService
  ) {}

  public function index(Request $request)
  {
    $paginate = $request->boolean('paginate', false);
    $perPage  = $request->input('per_page', 10);
    $page     = $request->input('page', 1);

    $applyJobs = $this->applyJobService->findAll(
      paginate: $paginate,
      perPage: $perPage,
      page: $page
    );

    return ApplyJobResource::collection($applyJobs);
  }

  public function store(CreateApplyJobRequest $request)
  {
    try {
      $applyJob = $this->applyJobService->apply($request->validated());

      return (new ApplyJobResource($applyJob))->additional([
        'message' => 'تم التقديم على الوظيفة بنجاح'
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'message' => $e->getMessage(),
      ], $e->getCode() == 422 ? 422 : 500);
    }
  }

  public function show(int $id): ApplyJobResource
  {
    $applyJob = $this->applyJobService->findOne($id);
    return new ApplyJobResource($applyJob);
  }
}
