<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subscription\CreateSubscriptionRequest;
use App\Http\Requests\Subscription\UpdateSubscriptionRequest;
use App\Http\Resources\SubscriptionResource;
use App\Service\SubscriptionService;

class SubscriptionController extends Controller
{
  public function __construct(
    private SubscriptionService $subscriptionService
  ) {}

  public function index()
  {
    $subscriptions = $this->subscriptionService->findAll();
    return SubscriptionResource::collection($subscriptions);
  }

  public function store(CreateSubscriptionRequest $request)
  {
    $subscription = $this->subscriptionService->create($request->validated());
    return response()->json([
      'data'    => new SubscriptionResource($subscription)
    ], 201);
  }

  public function show(int $id)
  {
    $subscription = $this->subscriptionService->findOne($id);
    return new SubscriptionResource($subscription);
  }

  public function update(UpdateSubscriptionRequest $request, int $id)
  {
    $subscription = $this->subscriptionService->update($id, $request->validated());
    return response()->json([
      'data'    => new SubscriptionResource($subscription)
    ], 200);
  }

  public function destroy(int $id)
  {
    $this->subscriptionService->delete($id);
    return response()->json([
      'message' => 'Subscription deleted successfully'
    ], 200);
  }
}
