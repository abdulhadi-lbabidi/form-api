<?php

namespace App\Service;

use App\Models\AccountUpgradeRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class AccountUpgradeRequestService
{
  public function findAll(
    bool $paginate = false,
    int $perPage = 10,
    int $page = 1,
    array $columns = ["*"]
  ): LengthAwarePaginator|Collection {

    $query = QueryBuilder::for(AccountUpgradeRequest::class)
      ->with(['morphable'])
      ->allowedFilters(
        AllowedFilter::exact('status'),
        AllowedFilter::exact('morphable_type'),
        AllowedFilter::exact('morphable_id')  
      )
      ->defaultSort('-created_at');

    if ($paginate) {
      return $query->paginate(
        perPage: $perPage,
        page: $page,
        columns: $columns,
      );
    }

    return $query->get($columns);
  }

  public function findOne(int $id): AccountUpgradeRequest
  {
    return AccountUpgradeRequest::with(['morphable'])->findOrFail($id);
  }

  public function create(array $data): AccountUpgradeRequest
  {
    return AccountUpgradeRequest::create($data);
  }

  public function update(AccountUpgradeRequest $accountUpgradeRequest, array $data): AccountUpgradeRequest
  {
    $accountUpgradeRequest->update($data);
    return $accountUpgradeRequest;
  }

  public function delete(int $id): bool
  {
    $request = $this->findOne($id);
    return $request->delete();
  }
}