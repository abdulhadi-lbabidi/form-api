<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Worker\CreateWorkerRequest;
use App\Http\Requests\Worker\UpdateWorkerRequest;
use App\Http\Resources\WorkerResource;
use App\Models\Worker;
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
    $validated = $request->validated();
    $worker = $this->workerService->create(
      $validated,
      $request->file('image') ?? []
    );
    return new WorkerResource($worker);
  }


  public function show(int $id): WorkerResource
  {
    $worker = $this->workerService->findOne($id);
    return new WorkerResource($worker);
  }

  public function update(Worker $worker, UpdateWorkerRequest $request)
  {
    $validated = $request->validated();
    $newWorker = $this->workerService->update(
      $worker,
      $validated,
      $request->file('image')
    );
    return new WorkerResource($newWorker);
  }
  public function destroy(int $id)
  {
    $this->workerService->delete($id);
    return response()->json([
      'message' => 'Worker profile deleted successfully'
    ], 200);
  }
}
