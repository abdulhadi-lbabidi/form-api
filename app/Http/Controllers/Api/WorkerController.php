<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Worker\CreateWorkerRequest;
use App\Http\Requests\Worker\UpdateWorkerRequest;
use App\Http\Resources\WorkerResource;
use App\Service\WorkerService;

class WorkerController extends Controller
{
  public function __construct(
    private WorkerService $workerService
  ) {}

  public function index()
  {
    $workers = $this->workerService->findAll();
    return WorkerResource::collection($workers);
  }

  public function store(CreateWorkerRequest $request)
  {
    $worker = $this->workerService->create($request->validated());
    return response()->json([
      'data'    => new WorkerResource($worker)
    ], 201);
  }

  public function show(int $id): WorkerResource
  {
    $worker = $this->workerService->findOne($id);
    return new WorkerResource($worker);
  }

  public function update(UpdateWorkerRequest $request, int $id)
  {
    $worker = $this->workerService->update($id, $request->validated());
    return response()->json([
      'data'    => new WorkerResource($worker)
    ], 200);
  }

  public function destroy(int $id)
  {
    $this->workerService->delete($id);
    return response()->json([
      'message' => 'Worker profile deleted successfully'
    ], 200);
  }
}
