<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountUpgradeRequestResource\CreateAccountUpgradeRequestRequest;
use App\Http\Requests\AccountUpgradeRequestResource\UpdateAccountUpgradeRequestRequest;
use App\Http\Resources\AccountUpgradeRequestResource;
use App\Models\AccountUpgradeRequest;
use App\Service\AccountUpgradeRequestService;
use Illuminate\Http\Request;

class AccountUpgradeRequestController extends Controller
{
  public function __construct(
    private AccountUpgradeRequestService $upgradeRequestService
  ) {}

  public function index(Request $request)
  {
    $paginate = $request->boolean('paginate', false);
    $perPage  = $request->input('per_page', 10);
    $page     = $request->input('page', 1);

    $requests = $this->upgradeRequestService->findAll($paginate, $perPage, $page);

    return AccountUpgradeRequestResource::collection($requests);
  }

  public function store(CreateAccountUpgradeRequestRequest $request)
  {
    $validated = $request->validated();
    $upgradeRequest = $this->upgradeRequestService->create($validated);
    $upgradeRequest->load(['morphable']);

    return response()->json([
      'data' => new AccountUpgradeRequestResource($upgradeRequest)
    ], 201);
  }

  public function show(int $id)
  {
    $upgradeRequest = $this->upgradeRequestService->findOne($id);
    return new AccountUpgradeRequestResource($upgradeRequest);
  }

  public function update(AccountUpgradeRequest $accountUpgradeRequest, UpdateAccountUpgradeRequestRequest $request)
  {
    $validated = $request->validated();
    $updatedRequest = $this->upgradeRequestService->update($accountUpgradeRequest, $validated);

    return new AccountUpgradeRequestResource($updatedRequest);
  }

  public function destroy(int $id)
  {
    $this->upgradeRequestService->delete($id);

    return response()->json([
      'message' => 'Account Upgrade Request deleted successfully'
    ], 200);
  }
}
