<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Time\CreateTimeRequest;
use App\Http\Requests\Time\UpdateTimeRequest;
use App\Http\Resources\TimeResource;
use App\Service\TimeService;

class TimeController extends Controller
{

  public function __construct(
    private TimeService $timeService
  ) {}


  public function index()
  {
    $times = $this->timeService->findAll();
    return TimeResource::collection($times);
  }


  public function store(CreateTimeRequest $request)
  {
    $time = $this->timeService->create($request->validated());
    return response()->json([
      'data'    => new TimeResource($time)
    ], 201);
  }


  public function show(int $id)
  {
    $time = $this->timeService->findOne($id);
    return new TimeResource($time);
  }


  public function update(UpdateTimeRequest $request, int $id)
  {
    $time = $this->timeService->update($id, $request->validated());
    return response()->json([
      'data'    => new TimeResource($time)
    ], 200);
  }


  public function destroy(int $id)
  {
    $this->timeService->delete($id);
    return response()->json([
      'message' => 'Time deleted successfully'
    ], 200);
  }
}
